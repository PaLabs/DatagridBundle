<?php


namespace PaLabs\DatagridBundle\Grid\Export;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class GridExporterCompilerPass implements CompilerPassInterface
{
    const TAG_NAME = 'pa_datagrid.exporter';

    public function process(ContainerBuilder $container)
    {
        if (!$container->has(GridExporterFacade::class)) {
            throw new \Exception(sprintf("Service %s is not registered", GridExporterFacade::class));
        }

        $fieldRegistryDefinition = $container->findDefinition(GridExporterFacade::class);

        foreach ($container->findTaggedServiceIds(self::TAG_NAME) as $id => $tags) {
            $fieldRegistryDefinition->addMethodCall('registerExporter', [new Reference($id)]);
        }
    }
}