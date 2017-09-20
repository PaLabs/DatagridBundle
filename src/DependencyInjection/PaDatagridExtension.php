<?php


namespace PaLabs\DatagridBundle\DependencyInjection;


use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\Registry\FieldRegistryCompilerPass;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;
use PaLabs\DatagridBundle\DataSource\Filter\Registry\FilterRegistryCompilerPass;
use PaLabs\DatagridBundle\Grid\Export\GridExporter;
use PaLabs\DatagridBundle\Grid\Export\GridExporterCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class PaDatagridExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(FilterFormProvider::class)
            ->addTag(FilterRegistryCompilerPass::TAG_NAME);

        $container->registerForAutoconfiguration(Field::class)
            ->addTag(FieldRegistryCompilerPass::TAG_NAME);

        $container->registerForAutoconfiguration(GridExporter::class)
            ->addTag(GridExporterCompilerPass::TAG_NAME);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('fields.yml');
        $loader->load('filters.yml');


    }
}