<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Boolean;


use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class BooleanFilterData implements FilterDataInterface
{
    /** @var bool|null */
    protected $value;

    public function __construct(bool $value = null)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }


    public function isEnabled(): bool
    {
        return is_bool($this->value);
    }
}