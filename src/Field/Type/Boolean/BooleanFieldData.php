<?php


namespace PaLabs\DatagridBundle\Field\Type\Boolean;


use PaLabs\DatagridBundle\Field\Type\BaseFieldData;

class BooleanFieldData extends BaseFieldData
{
    protected $value;
    
    public function __construct(bool $url, array $options = [])
    {
        parent::__construct($options);
        $this->value = $value;
    }

    public function getValue(): bool
    {
        return $this->value;
    }
    
    
}