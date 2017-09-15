<?php

namespace PaLabs\DatagridBundle\DataTable\Column;


class Column
{
    public $headerName;
    public $columnListName;
    public $required;
    public $needDisplayCallback;
    public $headerOptionsCallback;
    public $columnMaker;
    public $headerBuilder;

    public function __construct(callable $columnMaker, array $parameters) {
        $this->headerName = $parameters['label'];
        $this->columnListName = $parameters['label'];
        $this->required = $parameters['required'] ?? false;
        $this->headerOptionsCallback = $parameters['header_options'] ?? null;
        $this->needDisplayCallback = $parameters['need_display'] ?? null;
        $this->headerBuilder = $parameters['header_builder'] ?? null;
        $this->columnMaker = $columnMaker;
    }
}