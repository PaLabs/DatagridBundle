<?php


namespace PaLabs\DatagridBundle\Field\Type\Boolean;


use PaLabs\DatagridBundle\Field\Type\BaseFieldData;

class BooleanFieldData extends BaseFieldData
{

    public function __construct(
        protected bool $value,
        protected bool $htmlLabel = true,
        array $options = [])
    {
        parent::__construct($options);
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public function isHtmlLabel(): bool
    {
        return $this->htmlLabel;
    }


    
}