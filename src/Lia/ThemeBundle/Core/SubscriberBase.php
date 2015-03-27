<?php

namespace Lia\ThemeBundle\Core;

use Lia\KernelBundle\Service\ServiceBase;

abstract class SubscriberBase
    extends    ServiceBase
    implements SubscriberInterface
{
    /**
     * @return string
     */
    public function getPathOfAsset()
    {
        return '/bundles/'.strtolower($this->getBundleName()).'/';
    }
}