<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Integer;


use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class IntegerFilterData implements FilterDataInterface
{
    /** @var  string */
    protected $value;

    public function __construct(string $value = null)
    {
        $this->value = $value;
    }

    public function isEnabled(): bool
    {
        return !empty($this->value);
    }

    public function getValue()
    {
        return $this->value;
    }


}