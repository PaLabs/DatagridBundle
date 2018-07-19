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

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

}