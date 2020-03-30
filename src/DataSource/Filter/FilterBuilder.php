<?php

namespace PaLabs\DatagridBundle\DataSource\Filter;


use Exception;

class FilterBuilder
{
    private array $filters = [];

    public function add(
        string $name,
        string $filterClass,
        array $formOptions = [],
        array $filterOptions = [])
    {
        if (isset($this->filters[$name])) {
            throw new Exception(sprintf("Filter already set, name=%s", $name));
        }

        $options = [
            'filterClass' => $filterClass,
            'filterOptions' => $filterOptions,
            'formOptions' => $formOptions,
        ];

        $this->filters[$name] = $options;

        return $this;
    }

    public function getFilters()
    {
        return $this->filters;
    }
}