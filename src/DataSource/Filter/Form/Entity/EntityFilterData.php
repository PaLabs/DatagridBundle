<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class EntityFilterData implements FilterDataInterface
{

    public function __construct(
        protected EntityFilterOperator $operator,
        protected mixed $value = null)
    {
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
            EntityFilterForm::OPERATOR_FIELD => $this->operator->value,
            EntityFilterForm::VALUE_FIELD => $this->value?->getId()
        ];
    }

    public function getOperator(): EntityFilterOperator
    {
        return $this->operator;
    }

    public function getValue()
    {
        return $this->value;
    }

}