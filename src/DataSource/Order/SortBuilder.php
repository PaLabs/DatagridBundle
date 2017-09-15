<?php


namespace PaLabs\DatagridBundle\DataSource\Order;


use PaLabs\DatagridBundle\DataSource\Doctrine\Order\QueryBuilderSorter;

class SortBuilder
{
    const SINGLE_FIELD_TYPE = 'single_field';
    const MULTIPLE_FIELDS_TYPE = 'multiple_fields';

    private $sorting = [];

    public function add(string $field, string $label, string $sorter = QueryBuilderSorter::class, array $options = [])
    {
        $this->checkOrderItemExists($field);
        $this->sorting[$field] = [
            'type' => self::SINGLE_FIELD_TYPE,
            'label' => $label,
            'field' => $field,
            'sorter' => $sorter,
            'options' => $options
        ];
        return $this;
    }

    public function addMultiField(string $name, string $label, array $fields, string $sorter = QueryBuilderSorter::class, array $options = [])
    {
        $this->checkOrderItemExists($name);
        $this->sorting[$name] = [
            'type' => self::MULTIPLE_FIELDS_TYPE,
            'label' => $label,
            'fields' => $fields,
            'sorter' => $sorter,
            'options' => $options
        ];
    }

    public function getSorting()
    {
        return $this->sorting;
    }

    private function checkOrderItemExists(string $name)
    {
        if (isset($this->sorting[$name])) {
            throw new \Exception(sprintf("Sorting already exists for item name=%s", $name));
        }
    }
}