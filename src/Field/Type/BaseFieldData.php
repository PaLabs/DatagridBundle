<?php


namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\FieldData;

abstract class BaseFieldData implements FieldData
{
    protected array $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function getOptions(): array {
        return $this->options;
    }
}