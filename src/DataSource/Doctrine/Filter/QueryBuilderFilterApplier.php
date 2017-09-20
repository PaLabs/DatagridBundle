<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;

class QueryBuilderFilterApplier
{
    public function apply(QueryBuilder $queryBuilder, array $filters, array $filterData)
    {
        foreach ($filters as $name => $filterDesc) {
            if (!empty($filterData[$name])) {
                $filter = $filterDesc['filter'];
                if($filter === null) {
                    continue;
                }
                if(!$filter instanceof DoctrineFilterInterface) {
                    continue;
                }

                $filter->apply($queryBuilder, $name, $filterData[$name], $filterDesc['filterOptions']);
            }
        }
    }
}