<?php

namespace PaLabs\DatagridBundle\Filter;


class FilterBuilder
{

    private $filters = [];

    public function add($name, $type, array $formOptions = [], $formType = null, array $filterOptions = [])
    {
        if (isset($this->filters[$name])) {
            throw new \Exception(sprintf("Filter already set, name=%s", $name));
        }

        /** @var FilterInterface $filter */
        $filter = new $type();
        $this->filters[$name] = [
            'filter' => $filter,
            'filterOptions' => $filterOptions,
            'formType' => !empty($formType) ? $formType : $filter->getDefaultFormType(),
            'formOptions' => array_merge($filter->getDefaultFormOptions(), $formOptions),
        ];
        return $this;
    }

    public function getFilters() {
        return $this->filters;
    }
}