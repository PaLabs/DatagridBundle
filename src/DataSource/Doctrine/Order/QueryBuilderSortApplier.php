<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Order;


use PaLabs\DatagridBundle\DataSource\Order\OrderItem;
use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Order\SortBuilder;
use PaLabs\DatagridBundle\DataSource\Order\Sorter;

class QueryBuilderSortApplier
{
    private $sorter;

    public function __construct()
    {
        $this->sorter = new QueryBuilderSorter();
    }

    public function apply(QueryBuilder $queryBuilder, array $orderConfig, array $orderItems)
    {
        /** @var OrderItem[] $orderItems */

        foreach ($orderItems as $orderItem) {
            $orderItemConfig = $orderConfig[$orderItem->getField()];

            if (!isset($orderItemConfig['type'])) {
                continue;
            }
            if ($orderItemConfig['type'] !== QueryBuilderSortApplier::class) {
                continue;
            }

            $this->sorter->apply($queryBuilder, $orderItem, $orderItemConfig);
        }

    }
}