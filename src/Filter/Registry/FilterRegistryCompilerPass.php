<?php


namespace PaLabs\DatagridBundle\Filter\Registry;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FilterRegistryCompilerPass implements CompilerPassInterface
{
    const SERVICE_ID = 'pa_datagrid.filter_registry';
    const TAG_NAME = 'pa_datagrid.filter';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has(self::SERVICE_ID)) {
            throw new \Exception(sprintf("Service %s is not registered", self::SERVICE_ID));
        }

        $fieldRegistryDefinition = $container->findDefinition(self::SERVICE_ID);

        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $id => $tags) {
            $fieldRegistryDefinition->addMethodCall('registerFilter', [new Reference($id)]);
        }
    }
}