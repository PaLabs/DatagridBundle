<?php

namespace PaLabs\DatagridBundle\Field\Registry;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FieldRegistryCompilerPass implements CompilerPassInterface
{
    const TAG_NAME = 'pa_datagrid.field';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has(FieldRegistry::class)) {
            throw new \Exception(sprintf("Service %s is not registered", FieldRegistry::class));
        }

        $fieldRegistryDefinition = $container->findDefinition(FieldRegistry::class);

        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $id => $tags) {
            $fieldRegistryDefinition->addMethodCall('registerField', [new Reference($id)]);
        }
    }
}