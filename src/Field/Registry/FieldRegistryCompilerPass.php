<?php

namespace PaLabs\DatagridBundle\Field\Registry;


use PaLabs\DatagridBundle\Field\Field;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FieldRegistryCompilerPass implements CompilerPassInterface
{
    const FIELD_REGISTRY_SERVICE_ID = 'pa_datagrid.field_registry';
    const TAG_NAME = 'pa_datagrid.field';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has(self::FIELD_REGISTRY_SERVICE_ID)) {
            throw new \Exception(sprintf("Service %s is not registered", self::FIELD_REGISTRY_SERVICE_ID));
        }

        $fieldRegistryDefinition = $container->findDefinition(self::FIELD_REGISTRY_SERVICE_ID);

        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $id => $tags) {
            $fieldRegistryDefinition->addMethodCall('registerField', [new Reference($id)]);
        }
    }
}