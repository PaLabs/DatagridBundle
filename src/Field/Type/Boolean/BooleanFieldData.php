<?php


namespace PaLabs\DatagridBundle\Field\Type\Boolean;


use PaLabs\DatagridBundle\Field\Type\BaseFieldData;

class BooleanFieldData extends BaseFieldData
{
    protected bool $value;
    
    public function __construct(bool $value, array $options = [])
    {
        parent::__construct($options);
        $this->value = $value;
    }

    public function getValue(): bool
    {
        return $this->value;
    }
    
    
}