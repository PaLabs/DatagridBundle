<?php

namespace PaLabs\DatagridBundle\Field;


class FieldRegistry
{
    private $fieldMap = [];

    public function addField(Field $field)
    {
        if (isset($this->fieldMap[$field->dataClass()])) {
            throw new \Exception(sprintf("Field with data class already registered, dataClass=%s, field=%s", $field->dataClass(), get_class($field)));
        }
        $this->fieldMap[$field->dataClass()] = $field;
    }


    /**
     * @param FieldData $fieldData
     * @return Field
     * @throws \Exception
     */
    public function getField(FieldData $fieldData)
    {
        $dataClass = get_class($fieldData);

        if (!isset($this->fieldMap[$dataClass])) {
            throw new \Exception(sprintf("Field does not registered for dataclass %s", $dataClass));
        }

        return $this->fieldMap[$dataClass];
    }
}