<?php

namespace Lia\ThemeBundle\Core;

use Lia\KernelBundle\Bag\CollectionBag;

interface SubscriberInterface
{
    /**
     * @return string
     */
    public function getPathOfAsset();

    /**
     * Allows to set the assets for the bundle
     * They will be on the top of the page
     * @param AssetBag $bag
     */
    public function setTop(AssetBag $bag);

    /**
     * Allows to set the assets for the bundle
     * They will be on the bottom of the page
     * @param AssetBag $bag
     */
    public function setBottom(AssetBag $bag);
}