<?php


namespace PaLabs\DatagridBundle\Field;


abstract class BaseFieldData implements FieldData
{
    protected $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function getOptions(): array {
        return $this->options;
    }
}