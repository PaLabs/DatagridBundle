<?php


namespace PaLabs\DatagridBundle\DataSource\Doctrine\Order;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Order\OrderItem;
use PaLabs\DatagridBundle\DataSource\Order\SortBuilder;
use PaLabs\DatagridBundle\DataSource\Order\Sorter;

class QueryBuilderSorter implements Sorter
{

    public function apply($qb, OrderItem $orderItem, array $config)
    {
        if(!$qb instanceof QueryBuilder) {
            throw new \LogicException("Can be applied only to QueryBuilder");
        }

        switch ($config['type']) {
            case SortBuilder::SINGLE_FIELD_TYPE:
                $this->applySingleField($qb, $orderItem, $config);
                break;
            case SortBuilder::MULTIPLE_FIELDS_TYPE:
                $this->applyMultipleFields($qb, $orderItem, $config);
                break;
            default:
                throw new \Exception(sprintf("Unknown order type: %s", $config['type']));
        }
    }

    private function applySingleField(QueryBuilder $queryBuilder, OrderItem $orderItem, array $config)
    {
        $queryBuilder->addOrderBy($config['field'], $orderItem->getDirection());
    }

    private function applyMultipleFields(QueryBuilder $queryBuilder, OrderItem $orderItem, $config)
    {
        foreach ($config['fields'] as $field) {
            $queryBuilder->addOrderBy($field, $orderItem->getDirection());
        }
    }
}