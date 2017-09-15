<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\Filter\FilterInterface;

class QueryBuilderFilterApplier
{
    public function apply(QueryBuilder $queryBuilder, array $filters, array $filterData)
    {
        foreach ($filters as $name => $filterDesc) {
            if (!empty($filterData[$name])) {

                /** @var FilterInterface $filter */
                $filter = $filterDesc['filter'];
                if($filter === null) {
                    continue;
                }

                $filter->apply($queryBuilder, $name, $filterData[$name], $filterDesc['filterOptions']);
            }
        }
    }
}