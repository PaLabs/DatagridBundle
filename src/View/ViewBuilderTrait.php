<?php

namespace PaLabs\DatagridBundle\View;


use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\FieldRenderer;

trait ViewBuilderTrait
{
    /** @var  FieldRenderer */
    protected $fieldRenderer;

    protected function viewRowsIterator($rows, $format)
    {
        foreach ($rows as $row) {
            yield $this->viewRowIterator($row, $format);
        }
    }

    protected function viewRowIterator($row, $format)
    {
        /** @var FieldData[] $row */
        foreach ($row as $field) {
            foreach ($this->fieldRenderer->renderField($field, $format) as $content) {
                yield $content;
            }
        }
    }

}