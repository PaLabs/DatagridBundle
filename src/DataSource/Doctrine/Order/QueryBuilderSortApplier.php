<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Order;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Order\OrderItem;

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
            $options = $orderConfig[$orderItem->getField()]['options'];

            if (!isset($options['sorter'])) {
                continue;
            }
            if ($options['sorter'] !== QueryBuilderSortApplier::class) {
                continue;
            }

            $this->sorter->apply($queryBuilder, $orderItem, $options);
        }
    }

}