<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Registry;


use PaLabs\DatagridBundle\DataSource\Filter\FilterInterface;

class FilterRegistry
{
    private $filters = [];

    public function registerFilter(FilterInterface $filter)
    {
        $filterClass = get_class($filter);

        if (isset($this->filters[$filterClass])) {
            throw new \Exception(sprintf("Filter has been already registered, %s", $filterClass));
        }
        $this->filters[$filterClass] = $filter;
    }

    public function getFilter(string $filterClass): FilterInterface
    {
        if (!isset($this->filters[$filterClass])) {
            throw new \Exception(sprintf("Filter has not registered, %s", $filterClass));
        }
        return $this->filters[$filterClass];
    }
}