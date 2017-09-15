<?php


namespace PaLabs\DatagridBundle\Grid\Export;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class GridExporterCompilerPass implements CompilerPassInterface
{
    const SERVICE_ID = 'pa_datagrid.exporter';
    const TAG_NAME = 'pa_datagrid.exporter';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has(self::SERVICE_ID)) {
            throw new \Exception(sprintf("Service %s is not registered", self::SERVICE_ID));
        }

        $fieldRegistryDefinition = $container->findDefinition(self::SERVICE_ID);

        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $id => $tags) {
            $fieldRegistryDefinition->addMethodCall('registerExporter', [new Reference($id)]);
        }
    }
}