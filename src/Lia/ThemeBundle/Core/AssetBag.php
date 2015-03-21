<?php

namespace Lia\ThemeBundle\Core;

class AssetBag
{
    /**
     * @var Bag
     */
    public $javascript;

    /**
     * @var Bag
     */
    public $styleSheet;

    public function __construct()
    {
        $this->javascript = new Bag();
        $this->styleSheet = new Bag();
    }
}