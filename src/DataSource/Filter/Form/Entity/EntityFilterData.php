<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class EntityFilterData implements FilterDataInterface
{
    protected string $operator;
    protected $value;

    public function __construct(string $operator, $value = null)
    {
        if(!EntityFilterOperator::valid($operator)) {
            throw new \LogicException(sprintf('EntityFilter operator %s is not a valid operator', $operator));
        }
        $this->operator = $operator;
        $this->value = $value;
    }

    public function isEnabled(): bool {
        if(in_array($this->operator, [EntityFilterOperator::OPERATOR_EMPTY, EntityFilterOperator::OPERATOR_NOT_EMPTY])) {
            return true;
        }
        return !empty($this->value);
    }

    public function toUrlParams(): array
    {
        if(!$this->isEnabled()) {
            return [];
        }
        return [
            EntityFilterForm::OPERATOR_FIELD => $this->operator,
            EntityFilterForm::VALUE_FIELD => $this->value === null ? null : $this->value->getId()
        ];
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