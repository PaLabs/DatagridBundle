<?php


namespace PaLabs\DatagridBundle\DataSource;


class OrderItem
{
    const DESC = 'desc';
    const ASC = 'asc';

    public $field;
    public $direction;

    public function __construct(string $field, string $direction) {
        if(!in_array($direction, [self::ASC, self::DESC])) {
            throw new \Exception("Invalid direction value");
        }
        $this->field = $field;
        $this->direction = $direction;
    }
}