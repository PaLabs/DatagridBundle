<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class EntityFilterData implements FilterDataInterface
{
    /** @var  string */
    protected $operator;

    /** @var  object */
    protected $value;

    public function __construct(string $operator, $value = null)
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