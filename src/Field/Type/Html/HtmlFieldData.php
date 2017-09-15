<?php


namespace PaLabs\DatagridBundle\Field\Type\Html;


use PaLabs\DatagridBundle\Field\Type\BaseFieldData;

class HtmlFieldData extends BaseFieldData
{
    protected $value;

    public function __construct(string $value, array $options = [])
    {
        parent::__construct($options);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

}