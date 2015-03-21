<?php

namespace Lia\ThemeBundle\Core;

interface PluginInterface
{
    public function getCssFiles();

    public function getJavascriptFiles();
}