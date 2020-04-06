<?php

namespace PaLabs\DatagridBundle\Field\Registry;


use Exception;
use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\FieldData;

class FieldRegistry
{
    private array $fields = [];

    public function registerField(Field $field)
    {
        if (isset($this->fields[$field->dataClass()])) {
            throw new Exception(sprintf("Field with data class already registered, dataClass=%s, field=%s", $field->dataClass(), get_class($field)));
        }
        $this->fields[$field->dataClass()] = $field;
    }


    public function getField(FieldData $fieldData): Field
    {
        $dataClass = get_class($fieldData);

        if (!isset($this->fields[$dataClass])) {
            throw new Exception(sprintf("Field does not registered for dataclass %s", $dataClass));
        }

        return $this->fields[$dataClass];
    }
}