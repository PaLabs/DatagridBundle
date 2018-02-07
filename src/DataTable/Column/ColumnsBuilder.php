<?php

namespace PaLabs\DatagridBundle\DataTable\Column;


class ColumnsBuilder
{
    private $columns = [];

    public function add(Column $column)
    {
        if (array_key_exists($column->getName(), $this->columns)) {
            throw new \Exception(sprintf('Column already exists in grid fields, name=%s', $column->getName()));
        }

        $this->columns[$column->getName()] = $column;
        return $this;
    }

    public function addColumns(array $callbacks, array $options)
    {
        foreach ($callbacks as $name => $callback) {
            if (!isset($options[$name])) {
                throw new \Exception(sprintf("Options is not set form column %s", $name));
            }

            $columnOptions = $this->createColumnOptions($options[$name]);

            $this->add(new Column($name, $callback, $columnOptions));
        }
    }

    protected function createColumnOptions($value) {
        if (is_string($value)) {
            return new ColumnOptions($value);
        } else if(is_array($value)) {
            return ColumnOptions::fromArray($value);
        } else if($value instanceof ColumnOptions) {
            return $value;
        } else {
            throw new \Exception("Unknown type of column options");
        }
    }

    public function build()
    {
        return $this->columns;
    }
}