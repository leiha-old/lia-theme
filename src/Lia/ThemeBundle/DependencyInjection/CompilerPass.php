<?php

namespace Lia\ThemeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;


class CompilerPass
    implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('lia.service.theme')) {
            return;
        }

        $definition = $container->getDefinition(
            'lia.service.theme'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'lia.service.theme'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall('register', array(new Reference($id)));
        }
    }
}