<?php

namespace PaLabs\DatagridBundle\DataTable\Column;


class Column
{
    protected string $name;
    protected $columnMaker;
    protected ColumnOptions $options;

    public function __construct(string $name, callable $columnMaker, ColumnOptions $options) {
        $this->name = $name;
        $this->columnMaker = $columnMaker;
        $this->options = $options;
    }

    public function getName(): string
    {
        return $this->name;
    }
    
    public function getColumnMaker(): callable
    {
        return $this->columnMaker;
    }


    public function getOptions(): ColumnOptions
    {
        return $this->options;
    }

}