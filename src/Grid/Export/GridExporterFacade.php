<?php


namespace PaLabs\DatagridBundle\Grid\Export;


use Exception;
use PaLabs\DatagridBundle\Grid\View\GridView;

class GridExporterFacade
{
    protected array $exporters = [];

    public function registerExporter(GridExporter $exporter) {
        $format = $exporter->supportedFormat();

        if(isset($this->exporters[$format])) {
            throw new Exception(sprintf("Exporter has already registered, format=%s", $format));
        }
        $this->exporters[$format] = $exporter;
    }

    public function export(GridView $view, string $format, string $fileName) {
        if(!isset($this->exporters[$format])) {
            throw new Exception(sprintf("Exporter has not registered, format=%s", $format));
        }
        /** @var GridExporter $exporter */
        $exporter = $this->exporters[$format];
        return $exporter->export($view, $fileName);
    }
}