<?php

namespace PaLabs\DatagridBundle\Field;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FieldRegistryCompilerPass implements CompilerPassInterface
{
    const FIELD_REGISTRY_SERVICE_ID = 'pa_datagrid.field_registry';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has(self::FIELD_REGISTRY_SERVICE_ID)) {
            throw new \Exception(sprintf("Service %s is not registered", self::FIELD_REGISTRY_SERVICE_ID));
        }

        $fieldRegistryDefinition = $container->findDefinition(self::FIELD_REGISTRY_SERVICE_ID);

        foreach ($container->getDefinitions() as $id => $definition) {
            if (is_subclass_of($definition->getClass(), Field::class)) {
                $fieldRegistryDefinition->addMethodCall('addField', [new Reference($id)]);
            }
        }
    }
}