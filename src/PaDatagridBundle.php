<?php


namespace PaLabs\DatagridBundle;


use PaLabs\DatagridBundle\DependencyInjection\PaDatagridExtension;
use PaLabs\DatagridBundle\Field\FieldRegistryCompilerPass;
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
            ->addCompilerPass(new FieldRegistryCompilerPass());
    }
}