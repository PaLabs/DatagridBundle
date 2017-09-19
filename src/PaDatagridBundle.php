<?php


namespace PaLabs\DatagridBundle;


use PaLabs\DatagridBundle\DependencyInjection\PaDatagridExtension;
use PaLabs\DatagridBundle\Field\Registry\FieldRegistryCompilerPass;
use PaLabs\DatagridBundle\DataSource\Filter\Registry\FilterRegistryCompilerPass;
use PaLabs\DatagridBundle\Grid\Export\GridExporterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PaDatagridBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new PaDatagridExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new FieldRegistryCompilerPass())
            ->addCompilerPass(new FilterRegistryCompilerPass())
            ->addCompilerPass(new GridExporterCompilerPass());
    }
}