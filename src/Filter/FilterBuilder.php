<?php

namespace PaLabs\DatagridBundle\Filter;


use PaLabs\DatagridBundle\Filter\Registry\FilterRegistry;

class FilterBuilder
{
    private $filterRegistry;
    private $filters = [];

    public function __construct(FilterRegistry $filterRegistry)
    {
        $this->filterRegistry = $filterRegistry;
    }


    public function add(string $name, string $filterType = null, array $formOptions = [], string $formType = null, array $filterOptions = [])
    {
        if (isset($this->filters[$name])) {
            throw new \Exception(sprintf("Filter already set, name=%s", $name));
        }

        if($filterType === null && $formType === null) {
            throw new \LogicException("Filter type or form type must be set");
        }

        if($filterType !== null) {
            $filter = $this->filterRegistry->getFilter($filterType);
             $options = [
                'filter' => $filter,
                'filterOptions' => $filterOptions,
                'formType' => $formType ?? $filter->formType(),
                'formOptions' => array_merge($filter->formOptions(), $formOptions),
            ];
        } else {
            $options = [
                'filter' => null,
                'filterOptions' => $filterOptions,
                'formType' => $formType,
                'formOptions' => $formOptions,
            ];
        }
        $this->filters[$name] = $options;

        return $this;
    }

    public function getFilters() {
        return $this->filters;
    }
}