<?php


namespace PaLabs\DatagridBundle\DataTable\Column;


class NameLabelColumnBuilder
{
    private ColumnsBuilder $builder;

    public function __construct(ColumnsBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function add(string $name, string $label, callable $columnMaker): self
    {
        $columnOptions = new ColumnOptions($label);
        $this->builder->add(new Column($name, $columnMaker, $columnOptions));

        return $this;
    }
}