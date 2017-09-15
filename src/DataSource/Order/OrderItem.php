<?php


namespace PaLabs\DatagridBundle\DataSource\Order;


class OrderItem
{
    const DESC = 'desc';
    const ASC = 'asc';

    protected $field;
    protected $direction;

    public function __construct(string $field, string $direction = self::ASC) {
        if(!in_array($direction, [self::ASC, self::DESC])) {
            throw new \Exception("Invalid direction value");
        }
        $this->field = $field;
        $this->direction = $direction;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }


}