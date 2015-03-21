<?php

namespace Lia\ThemeBundle\DependencyInjection;

use Lia\KernelBundle\Bag\CollectionBag;
use Lia\KernelBundle\Service\ServiceBase;
use Lia\ThemeBundle\Core\AssetBag;
use Lia\ThemeBundle\Core\SubscriberInterface;
use Lia\ThemeBundle\Renderer\Javascript;
use Lia\ThemeBundle\Renderer\StyleSheet;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Service
    extends ServiceBase
{
    /**
     * @var CollectionBag
     */
    private $subscribers;

    /**
     * @var CollectionBag
     */
    private $assetsTop;

    /**
     * @var CollectionBag
     */
    private $assetsBottom;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->assetsTop    = new CollectionBag();
        $this->assetsBottom = new CollectionBag();
        $this->subscribers  = new CollectionBag();
    }

    /**
     * This method is called in the CompilerPass class who is herself called in the Bundle class
     * @param SubscriberInterface $subscriber
     */
    public function register(SubscriberInterface $subscriber)
    {
        $this->subscribers->add($subscriber->getPathOfAsset(), $subscriber);
    }

    /**
     * @return string
     */
    public function renderTop()
    {
        $this->merge();
        return $this->render($this->assetsTop);
    }

    /**
     * @return string
     */
    public function renderBottom()
    {
        return $this->render($this->assetsBottom);
    }

    /**
     * @return void
     */
    private function merge()
    {
        $this->subscribers->iterate(
            function(SubscriberInterface $subscriber) {

                /* @var AssetBag $bag */
                $bag = $this->assetsTop->add(
                    $subscriber->getPathOfAsset(),
                    new AssetBag(),
                    true
                );
                $subscriber->setTop($bag);

                /* @var AssetBag $bag */
                $bag = $this->assetsBottom->add(
                    $subscriber->getPathOfAsset(),
                    new AssetBag(),
                    true
                );
                $subscriber->setBottom($bag);
            }
        );
    }

    /**
     * @param CollectionBag $bag
     * @return string
     */
    private function render(CollectionBag $bag)
    {
        return $bag->iterate(function(AssetBag $bag, $path)
        {
            $ret = $bag->styleSheet->files->iterate(
                function($item) use ($path) {
                    return "\n".'<link rel="stylesheet" href="'.$path.$item.'" />';
                }
            );

            $ret .= $bag->javascript->files->iterate(
                function($item) use ($path) {
                    return "\n".'<script type="text/javascript" src="'.$path.$item.'"></script>';
                }
            );

            $ret .= $bag->styleSheet->blocks->iterate(
                function($item) use ($path) {
                    return "\n".'<style type="text/css">'.$item.'</style>';
                }
            );

            $ret .= $bag->javascript->blocks->iterate(
                function($item) use ($path) {
                    return "\n".'<script type="text/javascript">'.$item.'</script>';
                }
            );

            return $ret;
        });
    }
}
