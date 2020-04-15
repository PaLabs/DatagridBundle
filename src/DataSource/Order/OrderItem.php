<?php


namespace PaLabs\DatagridBundle\DataSource\Order;


use Exception;

class OrderItem
{
    protected string $field;
    protected OrderDirection $direction;

    public function __construct(string $field, ?OrderDirection $direction = null) {
        $this->field = $field;
        $this->direction = $direction === null ? OrderDirection::$ASC : $direction;
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