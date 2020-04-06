<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\String;


use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class StringFilterData implements FilterDataInterface
{
    protected StringFilterOperator $operator;
    protected ?string $value;

    public function __construct(StringFilterOperator $operator, ?string $value = null)
    {
        $this->operator = $operator;
        $this->value = $value;
    }

    public function isEnabled(): bool {
        if(in_array($this->operator, [StringFilterOperator::$OPERATOR_EMPTY, StringFilterOperator::$OPERATOR_NOT_EMPTY])) {
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
            StringFilterForm::OPERATOR_FIELD => $this->operator,
            StringFilterForm::VALUE_FIELD => $this->value
        ];
    }

    public function getOperator(): StringFilterOperator
    {
        return $this->operator;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

}