<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Registry;


use Exception;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;

class FilterRegistry
{
    private array $filters = [];

    public function registerFilter(FilterFormProvider $filter)
    {
        $filterClass = get_class($filter);

        if (isset($this->filters[$filterClass])) {
            throw new Exception(sprintf("Filter has been already registered, %s", $filterClass));
        }
        $this->filters[$filterClass] = $filter;
    }

    public function getFilter(string $filterClass): FilterFormProvider
    {
        if (!isset($this->filters[$filterClass])) {
            throw new Exception(sprintf("Filter has not registered, %s", $filterClass));
        }
        return $this->filters[$filterClass];
    }
}