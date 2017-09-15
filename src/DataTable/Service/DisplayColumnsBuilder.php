<?php


namespace PaLabs\DatagridBundle\DataTable\Service;


use PaLabs\DatagridBundle\DataTable\Column\Column;
use PaLabs\DatagridBundle\Grid\GridContext;

class DisplayColumnsBuilder
{
    protected $columns;

    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    public function build(GridContext $context)
    {
        $selectedFields = $context->getDataTableSettings()->getSelectedFields();

        $displayFields = [];
        foreach ($this->columns as $fieldName => $field) {
            /** @var \PaLabs\DatagridBundle\DataTable\Column\Column $field */
            if ($field->required && $this->needDisplayField($field, $context)) {
                $displayFields[] = $fieldName;
            }
        }

        foreach ($selectedFields as $field) {
            /** @var string $field */
            if (!array_key_exists($field, $this->columns)) {
                throw new \LogicException(sprintf("Unknown column field: %s", $field));
            }

            /** @var \PaLabs\DatagridBundle\DataTable\Column\Column $fieldDesc */
            $fieldDesc = $this->columns[$field];

            if ($this->needDisplayField($fieldDesc, $context)) {
                $displayFields[] = $field;
            }
        }

        return $displayFields;
    }

    private function needDisplayField(Column $field, GridContext $context)
    {
        if ($field->needDisplayCallback === null) {
            return true;
        }
        $callback = $field->needDisplayCallback;
        return $callback($context) === true;
    }
}