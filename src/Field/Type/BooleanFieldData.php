<?php


namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\BaseFieldData;

class BooleanFieldData extends BaseFieldData
{
    protected $value;
    
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