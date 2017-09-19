<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\String;


use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class StringFilterData implements FilterDataInterface
{
    /** @var  string */
    protected $operator;

    /** @var  string */
    protected $value;

    public function __construct(string $operator, string $value = null)
    {
        $this->operator = $operator;
        $this->value = $value;
    }

    public function isEnabled(): bool {
        return !empty($this->value);
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getValue()
    {
        return $this->value;
    }

}