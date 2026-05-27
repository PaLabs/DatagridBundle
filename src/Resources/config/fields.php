<?php

use PaLabs\DatagridBundle\Field\Type\Boolean\BooleanField;
use PaLabs\DatagridBundle\Field\Type\Date\DateField;
use PaLabs\DatagridBundle\Field\Type\DateTime\DateTimeField;
use PaLabs\DatagridBundle\Field\Type\Html\HtmlField;
use PaLabs\DatagridBundle\Field\Type\String\StringField;
use PaLabs\DatagridBundle\Field\Type\Url\UrlField;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->set(BooleanField::class)
        ->tag('pa_datagrid.field');

    $services
        ->set(DateField::class)
        ->private()
        ->tag('pa_datagrid.field');

    $services
        ->set(DateTimeField::class)
        ->private()
        ->tag('pa_datagrid.field');

    $services
        ->set(StringField::class)
        ->private()
        ->tag('pa_datagrid.field');

    $services
        ->set(HtmlField::class)
        ->private()
        ->tag('pa_datagrid.field');

    $services
        ->set(UrlField::class)
        ->private()
        ->tag('pa_datagrid.field');

};