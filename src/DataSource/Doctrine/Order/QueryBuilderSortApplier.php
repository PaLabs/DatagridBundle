<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Order;


use PaLabs\DatagridBundle\DataSource\Order\OrderItem;
use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Order\SortBuilder;
use PaLabs\DatagridBundle\DataSource\Order\Sorter;

class QueryBuilderSortApplier
{
    private $sorters = [];

    public function __construct()
    {
        $this->sorters[QueryBuilderSorter::class] = new QueryBuilderSorter();
    }

    public function apply(QueryBuilder $queryBuilder, array $orderConfig, array $orderItems)
    {
        /** @var OrderItem[] $orderItems */

        foreach ($orderItems as $orderItem) {
            $orderItemConfig = $orderConfig[$orderItem->getField()];
            $sorterClass = $orderItemConfig['sorter'];
            if($sorterClass === null) {
                continue;
            }
            if(!isset($this->sorters[$sorterClass])) {
                continue;
            }

            /** @var Sorter $sorter */
            $sorter = $this->sorters[$sorterClass];
            $sorter->apply($queryBuilder, $orderItem, $orderItemConfig);
        }

    }
}