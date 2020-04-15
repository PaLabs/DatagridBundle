<?php


namespace PaLabs\DatagridBundle\DataSource\Order;


use PaLabs\Enum\Enum;

class OrderDirection extends Enum
{
    public static OrderDirection $ASC, $DESC;
}