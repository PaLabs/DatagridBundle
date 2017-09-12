<?php

namespace PaLabs\DatagridBundle\Field;


class GridColumnsBuilder
{
    private $columns = [];

    public function add($name, GridColumn $column) {
        if(array_key_exists($name, $this->columns)) {
            throw new \Exception(sprintf('Column already exists in grid fields, name=%s', $name));
        }

        $this->columns[$name] = $column;
        return $this;
    }

    public function build() {
        return $this->columns;
    }
}