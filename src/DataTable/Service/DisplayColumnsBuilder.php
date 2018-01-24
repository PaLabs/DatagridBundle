<?php


namespace PaLabs\DatagridBundle\DataTable\Service;


use PaLabs\DatagridBundle\DataTable\Column\Column;
use PaLabs\DatagridBundle\Grid\GridContext;

class DisplayColumnsBuilder
{

    public function build(array $columns, GridContext $context)
    {
        $selectedFields = $context->getDataTableSettings()->getSelectedFields();

        $displayFields = [];
        foreach ($columns as $fieldName => $field) {
            /** @var \PaLabs\DatagridBundle\DataTable\Column\Column $field */
            if ($field->isRequired() && $this->needDisplayField($field, $context)) {
                $displayFields[] = $fieldName;
            }
        }

        foreach ($selectedFields as $field) {
            /** @var string $field */
            if (!array_key_exists($field, $columns)) {
                throw new \LogicException(sprintf("Unknown column field: %s", $field));
            }

            /** @var \PaLabs\DatagridBundle\DataTable\Column\Column $fieldDesc */
            $fieldDesc = $columns[$field];

            if ($this->needDisplayField($fieldDesc, $context)) {
                $displayFields[] = $field;
            }
        }

        return $displayFields;
    }

    private function needDisplayField(Column $field, GridContext $context)
    {
        if ($field->getNeedDisplayCallback() === null) {
            return true;
        }
        $callback = $field->getNeedDisplayCallback();
        return $callback($context) === true;
    }
}