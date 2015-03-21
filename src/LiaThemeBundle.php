<?php

namespace Lia\Kernel\ThemeBundle;

use Lia\KernelBundle\Bundle\BundleBase;
use Lia\ThemeBundle\DependencyInjection\CompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LiaThemeBundle
    extends BundleBase
{
    public function getAlias()
    {
        return 'theme';
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new CompilerPass());
    }
}
