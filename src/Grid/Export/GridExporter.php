<?php


namespace PaLabs\DatagridBundle\Grid\Export;


use PaLabs\DatagridBundle\Grid\View\GridView;

interface GridExporter
{
    public function supportedFormat(): string;

    public function export(GridView $view, string $fileName);
}