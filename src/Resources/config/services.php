<?php

use PaLabs\DatagridBundle\DataSource\Doctrine\DoctrineDataSourceServices;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\QueryBuilderFilterApplier;
use PaLabs\DatagridBundle\DataSource\Doctrine\Order\QueryBuilderSortApplier;
use PaLabs\DatagridBundle\DataSource\Filter\FilterCollectionForm;
use PaLabs\DatagridBundle\DataSource\Filter\Registry\FilterRegistry;
use PaLabs\DatagridBundle\Field\Registry\FieldRegistry;
use PaLabs\DatagridBundle\Field\Renderer\FieldRenderer;
use PaLabs\DatagridBundle\Form\Type\EnumForm;
use PaLabs\DatagridBundle\Grid\Export\GridExporterFacade;
use PaLabs\DatagridBundle\Grid\Export\XlsxExporter;
use PaLabs\DatagridBundle\Grid\View\GridViewBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services->set(EnumForm::class)
        ->private()
        ->args([
            service('translator')
        ])
        ->tag('form.type');

    $services
        ->set(FieldRegistry::class)
        ->private();

    $services
        ->set(FilterRegistry::class)
        ->private();

    $services
        ->set(FieldRenderer::class)
        ->args([
            service(FieldRegistry::class)
        ]);

    $services
        ->set(GridViewBuilder::class)
        ->private()
        ->args([
            service('form.factory'),
            service(FieldRenderer::class)
        ]);

    $services
        ->set(XlsxExporter::class)
        ->private()
        ->tag('pa_datagrid.exporter');

    $services
        ->set(GridExporterFacade::class)
        ->private();

    $services
        ->set(QueryBuilderFilterApplier::class)
        ->private()
        ->args([
            service(FilterRegistry::class),
        ]);

    $services
        ->set(QueryBuilderSortApplier::class)
        ->private();

    $services
        ->set(DoctrineDataSourceServices::class)
        ->private()
    ->args([
        service('doctrine.orm.entity_manager'),
        service('knp_paginator'),
        service(QueryBuilderFilterApplier::class),
        service(QueryBuilderSortApplier::class)
    ]);

    $services
        ->set(FilterCollectionForm::class)
        ->private()
        ->args([
            service(FilterRegistry::class)
        ])
        ->tag('form.type');
};