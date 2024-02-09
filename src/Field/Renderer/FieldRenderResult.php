<?php


namespace PaLabs\DatagridBundle\Field\Renderer;


use PaLabs\DatagridBundle\Field\FieldData;

class FieldRenderResult
{

    public function __construct(
        protected FieldData $fieldData,
        protected mixed $renderedContent)
    {
    }

    public function getFieldData(): FieldData
    {
        return $this->fieldData;
    }

    public function getRenderedContent(): mixed
    {
        return $this->renderedContent;
    }


}