<?php


namespace PaLabs\DatagridBundle\DataTable\Column;


class NameLabelColumnBuilder
{

    public function __construct(private readonly ColumnsBuilder $builder)
    {
    }

    public function add(string $name, string $label, callable $columnMaker, string $group = ''): self
    {
        $columnOptions = new ColumnOptions($label, $group);
        $this->builder->add(new Column($name, $columnMaker, $columnOptions));

        return $this;
    }
}