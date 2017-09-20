<?php

namespace PaLabs\DatagridBundle\DataSource\Filter;


use PaLabs\DatagridBundle\DataSource\Filter\Registry\FilterRegistry;

class FilterBuilder
{
    private $filterRegistry;
    private $filters = [];

    public function __construct(FilterRegistry $filterRegistry)
    {
        $this->filterRegistry = $filterRegistry;
    }


    public function add(string $name, string $filterType, array $formOptions = [], string $formType = null, array $filterOptions = [])
    {
        if (isset($this->filters[$name])) {
            throw new \Exception(sprintf("Filter already set, name=%s", $name));
        }

        $filter = $this->filterRegistry->getFilter($filterType);
        $options = [
            'filter' => $filter,
            'filterOptions' => $filterOptions,
            'formType' => $formType ?? $filter->formType(),
            'formOptions' => array_merge($filter->formOptions(), $formOptions),
        ];

        $this->filters[$name] = $options;

        return $this;
    }

    public function addForm(string $name, string $formType, array $formOptions = [], array $filterOptions = [])
    {
        if (isset($this->filters[$name])) {
            throw new \Exception(sprintf("Filter already set, name=%s", $name));
        }

        $options = [
            'filter' => null,
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