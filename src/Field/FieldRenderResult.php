<?php


namespace PaLabs\DatagridBundle\Field;


class FieldRenderResult
{
    protected $fieldData;
    protected $renderedContent;

    public function __construct(FieldData $fieldData, $renderedContent)
    {
        $this->fieldData = $fieldData;
        $this->renderedContent = $renderedContent;
    }

    public function getFieldData(): FieldData
    {
        return $this->fieldData;
    }

    public function getRenderedContent()
    {
        return $this->renderedContent;
    }


}