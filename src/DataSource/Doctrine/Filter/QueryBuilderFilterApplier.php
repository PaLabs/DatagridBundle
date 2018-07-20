<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Filter\Registry\FilterRegistry;

class QueryBuilderFilterApplier
{
    protected $filterRegistry;

    public function __construct(FilterRegistry $filterRegistry)
    {
        $this->filterRegistry = $filterRegistry;
    }

    public function apply(QueryBuilder $queryBuilder, array $filters, array $filterData)
    {
        foreach ($filters as $name => $filterDesc) {
            if (!empty($filterData[$name])) {
                $filterClass = $filterDesc['filterClass'];
                if($filterClass === null) {
                    continue;
                }

                $filter = $this->filterRegistry->getFilter($filterClass);
                if(!$filter instanceof DoctrineFilterInterface) {
                    continue;
                }

                $filter->apply($queryBuilder, $name, $filterData[$name], $filterDesc['filterOptions']);
            }
        }
    }
}