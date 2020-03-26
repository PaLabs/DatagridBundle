<?php

namespace PaLabs\DatagridBundle\DataSource\Filter;


class FilterBuilder
{
    private array $filters = [];

    public function add(
        string $name,
        string $filterClass,
        array $formOptions = [],
        string $formType = null,
        array $filterOptions = [])
    {
        if (isset($this->filters[$name])) {
            throw new \Exception(sprintf("Filter already set, name=%s", $name));
        }

        $options = [
            'filterClass' => $filterClass,
            'filterOptions' => $filterOptions,
            'formType' => $formType,
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