<?php


namespace PaLabs\DatagridBundle\DataSource\Order;


interface Sorter
{
    public function apply($sortable, OrderItem $orderItem, array $config);
}