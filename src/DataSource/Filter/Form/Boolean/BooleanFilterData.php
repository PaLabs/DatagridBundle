<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Boolean;


use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class BooleanFilterData implements FilterDataInterface
{
    protected ?bool $value;

    public function __construct(?bool $value = null)
    {
        $this->value = $value;
    }

    public function getValue(): ?bool
    {
        return $this->value;
    }


    public function isEnabled(): bool
    {
        return is_bool($this->value);
    }

    public function toUrlParams(): array
    {
        if($this->value === null) {
            return [];
        }

        return [
            BooleanFilterForm::VALUE_FIELD => $this->value,
        ];
    }
}