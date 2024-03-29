<?php


namespace PaLabs\DatagridBundle\DataSource\Order;


use Exception;

class OrderItem
{
    protected OrderDirection $direction;

    public function __construct(
        protected string $field,
        ?OrderDirection $direction = null)
    {
        $this->direction = $direction === null ? OrderDirection::ASC : $direction;
    }

    public static function ASC(string $field): OrderItem
    {
        return new OrderItem($field, OrderDirection::ASC);
    }

    public static function DESC(string $field): OrderItem
    {
        return new OrderItem($field, OrderDirection::DESC);
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getDirection(): OrderDirection
    {
        return $this->direction;
    }


}