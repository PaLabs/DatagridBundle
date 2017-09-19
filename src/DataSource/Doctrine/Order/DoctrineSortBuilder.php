<?php


namespace PaLabs\DatagridBundle\DataSource\Doctrine\Order;


use PaLabs\DatagridBundle\DataSource\Order\SortBuilder;

class DoctrineSortBuilder extends SortBuilder
{
    public function add(string $name, string $label, array $options = []) {
        $defaultOptions = [
            'field' => $name,
            'type' => QueryBuilderSorter::SINGLE_FIELD_TYPE
        ];
        return parent::add($name, $label, array_merge($defaultOptions, $options));
    }
}