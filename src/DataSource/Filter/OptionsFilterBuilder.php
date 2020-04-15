<?php


namespace PaLabs\DatagridBundle\DataSource\Filter;


use PaLabs\DatagridBundle\DataSource\Filter\Options\FilterOptions;

class OptionsFilterBuilder
{
    private FilterBuilder $builder;

    public function __construct(FilterBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function add(string $name, string $filterClass, ?FilterOptions $filterOptions = null): self
    {
        $this->builder->add(
            $name,
            $filterClass,
            $filterOptions === null ? [] : $filterOptions->formOptions(),
            $filterOptions === null ? [] : $filterOptions->filterOptions()
        );
        return $this;
    }
}