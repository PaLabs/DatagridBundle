<?php


namespace PaLabs\DatagridBundle\DataSource\Doctrine\Order;


use Doctrine\ORM\QueryBuilder;
use Exception;
use PaLabs\DatagridBundle\DataSource\Order\OrderItem;

class QueryBuilderSorter
{
    const SINGLE_FIELD_TYPE = 'single_field';
    const MULTIPLE_FIELDS_TYPE = 'multiple_fields';

    public function apply(QueryBuilder $qb, OrderItem $orderItem, array $config): void
    {
        switch ($config['type']) {
            case self::SINGLE_FIELD_TYPE:
                $this->applySingleField($qb, $orderItem, $config);
                break;
            case self::MULTIPLE_FIELDS_TYPE:
                $this->applyMultipleFields($qb, $orderItem, $config);
                break;
            default:
                throw new Exception(sprintf("Unknown order type: %s", $config['type']));
        }
    }

    private function applySingleField(QueryBuilder $queryBuilder, OrderItem $orderItem, array $config): void
    {
        $queryBuilder->addOrderBy($config['field'], $orderItem->getDirection()->value);
    }

    private function applyMultipleFields(QueryBuilder $queryBuilder, OrderItem $orderItem, $config): void
    {
        foreach ($config['fields'] as $field) {
            $queryBuilder->addOrderBy($field, $orderItem->getDirection()->value);
        }
    }
}