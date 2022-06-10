<?php


namespace PaLabs\DatagridBundle\DataSource\Order;


enum OrderDirection: string
{
    case ASC = 'ASC';
    case DESC = 'DESC';
}