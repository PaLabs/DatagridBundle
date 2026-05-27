<?php

use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\BooleanFilter;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\DateFilter;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\EntityFilter;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\IntegerFilter;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\IntegerHavingFilter;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\IsNullFilter;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\StringFilter;
use PaLabs\DatagridBundle\DataSource\Filter\NoOpFilter;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;


return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->set(NoOpFilter::class)
        ->private()
        ->tag('pa_datagrid.filter');

    $services
        ->set(BooleanFilter::class)
        ->private()
        ->tag('pa_datagrid.filter');

    $services
        ->set(DateFilter::class)
        ->private()
        ->tag('pa_datagrid.filter');

    $services
        ->set(EntityFilter::class)
        ->private()
        ->tag('pa_datagrid.filter');

    $services
        ->set(IntegerFilter::class)
        ->private()
        ->tag('pa_datagrid.filter');

    $services
        ->set(StringFilter::class)
        ->private()
        ->tag('pa_datagrid.filter');

    $services
        ->set(IntegerHavingFilter::class)
        ->private()
        ->tag('pa_datagrid.filter');

    $services
        ->set(IsNullFilter::class)
        ->private()
        ->tag('pa_datagrid.filter');
};