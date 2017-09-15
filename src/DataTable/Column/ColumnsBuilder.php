<?php

namespace PaLabs\DatagridBundle\DataTable\Column;


class ColumnsBuilder
{
    private $columns = [];

    public function add($name, Column $column)
    {
        if (array_key_exists($name, $this->columns)) {
            throw new \Exception(sprintf('Column already exists in grid fields, name=%s', $name));
        }

        $this->columns[$name] = $column;
        return $this;
    }

    public function addColumns(array $callbacks, array $options)
    {
        foreach ($callbacks as $name => $callback) {
            if (!isset($options[$name])) {
                throw new \Exception(sprintf("Options is not set form column %s", $name));
            }
            $columnOptions = $options[$name];
            if (is_string($columnOptions)) {
                $columnOptions = ['label' => $columnOptions];
            }

            $this->add($name, new Column($callback, $columnOptions));
        }
    }

    public function build()
    {
        return $this->columns;
    }
}