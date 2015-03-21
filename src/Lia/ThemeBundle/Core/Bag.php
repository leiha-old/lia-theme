<?php

namespace Lia\ThemeBundle\Core;

use Lia\KernelBundle\Bag\CollectionBag;

class Bag
{
    /**
     * @var CollectionBag
     */
    public $files;

    /**
     * @var CollectionBag
     */
    public $blocks;

    public function __construct()
    {
        $this->files  = new CollectionBag();
        $this->blocks = new CollectionBag();
    }
}