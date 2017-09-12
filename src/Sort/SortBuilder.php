<?php


namespace PaLabs\DatagridBundle\Sort;


class SortBuilder
{
    const INTERNAL_MODE = 'internal';
    const EXTERNAL_MODE = 'external';

    const SINGLE_FIELD_TYPE = 'single_field';
    const MULTIPLE_FIELDS_TYPE = 'multiple_fields';

    private $sorting = [];

    public function add(string $field, string $label, string $mode = self::INTERNAL_MODE )
    {
        $this->checkOrderItemExists($field);
        $this->sorting[$field] = [
            'mode' => $mode,
            'type' => self::SINGLE_FIELD_TYPE,
            'label' => $label,
            'field' => $field
        ];
        return $this;
    }

    public function addMultiField(string $name, string $label, array $fields, string $mode = self::INTERNAL_MODE)
    {
        $this->checkOrderItemExists($name);
        $this->sorting[$name] = [
            'mode' => $mode,
            'type' => self::MULTIPLE_FIELDS_TYPE,
            'label' => $label,
            'fields' => $fields
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