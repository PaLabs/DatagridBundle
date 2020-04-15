<?php

namespace PaLabs\DatagridBundle\DataTable\Column;


use Exception;

class ColumnsBuilder
{
    private array $columns = [];

    public function add(Column $column): self
    {
        if (array_key_exists($column->getName(), $this->columns)) {
            throw new Exception(sprintf('Column already exists in grid fields, name=%s', $column->getName()));
        }

        $this->columns[$column->getName()] = $column;
        return $this;
    }

    public function build(): array
    {
        return $this->columns;
    }

    public function withNameLabel(): NameLabelColumnBuilder {
        return new NameLabelColumnBuilder($this);
    }
}