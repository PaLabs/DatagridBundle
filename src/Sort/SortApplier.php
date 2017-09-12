<?php

namespace PaLabs\DatagridBundle\Sort;


use PaLabs\DatagridBundle\DataSource\OrderItem;
use Doctrine\ORM\QueryBuilder;

class SortApplier
{
    public function apply(QueryBuilder $queryBuilder, array $orderConfig, array $orderItems)
    {
        $internalOrderItems = array_filter($orderItems, function (OrderItem $orderItem) use ($orderConfig) {
            $orderItemConfig = $orderConfig[$orderItem->field];
            return $orderItemConfig['mode'] === SortBuilder::INTERNAL_MODE;
        });

        if (empty($internalOrderItems)) {
            return;
        }

        foreach ($internalOrderItems as $orderItem) {
            $orderItemConfig = $orderConfig[$orderItem->field];
            switch ($orderItemConfig['type']) {
                case SortBuilder::SINGLE_FIELD_TYPE:
                    $this->applySingleField($queryBuilder, $orderItem, $orderItemConfig);
                    break;
                case SortBuilder::MULTIPLE_FIELDS_TYPE:
                    $this->applyMultipleFields($queryBuilder, $orderItem, $orderItemConfig);
                    break;
                default:
                    throw new \Exception(sprintf("Unknown order type: %s", $orderItemConfig['type']));
            }

        }

    }

    private function applySingleField(QueryBuilder $queryBuilder, OrderItem $orderItem, array $orderItemConfig)
    {
        $queryBuilder->addOrderBy($orderItemConfig['field'], $orderItem->direction);
    }

    private function applyMultipleFields(QueryBuilder $queryBuilder, OrderItem $orderItem, $orderItemConfig)
    {
        foreach ($orderItemConfig['fields'] as $field) {
            $queryBuilder->addOrderBy($field, $orderItem->direction);
        }
    }
}