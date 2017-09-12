<?php

namespace PaLabs\DatagridBundle\Filter;


use Doctrine\ORM\QueryBuilder;

class FilterApplier
{

    public function apply(QueryBuilder $queryBuilder, array $filters, array $filterData, array $filterAdditionalOptions = [])
    {
        foreach ($filters as $name => $filterDesc) {
            if (!empty($filterData[$name])) {
                /** @var FilterInterface $filter */
                $filter = $filterDesc['filter'];
                if(!empty($filterAdditionalOptions)) {
                    $filterOptions = array_merge($filterDesc['filterOptions'], $filterAdditionalOptions);
                } else {
                    $filterOptions = $filterDesc['filterOptions'];
                }
                $filter->apply($queryBuilder, $name, $filterData[$name], $filterOptions);
            }
        }
    }
}