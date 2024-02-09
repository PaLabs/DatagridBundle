<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Registry;


use Exception;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FilterRegistryCompilerPass implements CompilerPassInterface
{
    const TAG_NAME = 'pa_datagrid.filter';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(FilterRegistry::class)) {
            throw new Exception(sprintf("Service %s is not registered", FilterRegistry::class));
        }

        $fieldRegistryDefinition = $container->findDefinition(FilterRegistry::class);

        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $id => $tags) {
            $fieldRegistryDefinition->addMethodCall('registerFilter', [new Reference($id)]);
        }
    }
}