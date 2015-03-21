<?php

namespace Lia\ThemeBundle\Core;

abstract class SubscriberWithPluginsBase
    extends SubscriberBase
{
    /**
     * Contains available plugins for the dhtmlx library
     * if the value of item in this array is true then a custom class must be present in :
     * Lia\Bridge\DhtmlxBundle\DependencyInjection\Asset\
     * This class must be named like this : [KeyOfItem]Plugin
     * @return array
     */
    abstract protected function getAvailablePlugins();

    /**
     * @return string
     */
    abstract protected function getNameSpaceOfPlugins();

    /**
     * @return array
     */
    abstract protected function getDefaultStyleSheet();

    /**
     * @return array
     */
    abstract protected function getDefaultJavascript();


    /**
     * @param string $pluginName
     * @return PluginInterface
     */
    private function getPlugin($pluginName)
    {
        $plugins = $this->getAvailablePlugins();
        if($plugins[$pluginName] instanceof PluginInterface){
            $return = $plugins[$pluginName];
        } else {
            if (!array_key_exists($pluginName, $plugins)) {
                //TODO : Make an exception

            } elseif ($plugins[$pluginName]) {
                $plugin = ucfirst($pluginName) . 'Plugin';
            } else {
                $plugin = 'GenericPlugin';
            }

            $plugin = $this->getNameSpaceOfPlugins() . $plugin;
            $return = $plugins[$pluginName] = new $plugin(
                $pluginName,
                $this->config->get('theme')
            );
        }
        return $return;
    }

    /**
     * Allows to set the assets for the bundle
     * They will be on the top of the page
     * @param AssetBag $bag
     */
    public function setTop(AssetBag $bag)
    {
        $bag->styleSheet->files->set($this->getDefaultStyleSheet());
        $this->config->iterateOnItem('plugins',
            function($value, $pluginName) use ($bag) {
                $bag->styleSheet->files->set(
                    $this->getPlugin($pluginName)->getCssFiles()
                );
            }
        );
    }

    /**
     * Allows to set the assets for the bundle
     * They will be on the bottom of the page
     * @param AssetBag $bag
     */
    public function setBottom(AssetBag $bag)
    {
        $bag->javascript->files->set($this->getDefaultJavascript());
        $this->config->iterateOnItem('plugins',
            function($value, $pluginName) use ($bag) {
                $bag->javascript->files->set(
                    $this->getPlugin($pluginName)->getJavascriptFiles()
                );
            }
        );
    }
}