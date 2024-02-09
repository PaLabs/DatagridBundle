<?php


namespace PaLabs\DatagridBundle\DataSource\Doctrine\Order;


use PaLabs\DatagridBundle\DataSource\Order\SortBuilder;

class DoctrineSortBuilder extends SortBuilder
{
    public function add(string $name, string $label, string $group = '', array $options = []): static {
        $defaultOptions = [
            'field' => $name,
            'sorter' => QueryBuilderSortApplier::class,
            'type' => QueryBuilderSorter::SINGLE_FIELD_TYPE
        ];
        return parent::add($name, $label, $group, array_merge($defaultOptions, $options));
    }
}