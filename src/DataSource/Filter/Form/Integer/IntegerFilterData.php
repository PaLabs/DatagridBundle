<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Integer;


use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class IntegerFilterData implements FilterDataInterface
{
    protected ?string $value;

    public function __construct(?string $value = null)
    {
        $this->value = $value;
    }

    public function isEnabled(): bool
    {
        return !empty($this->value);
    }

    public function toUrlParams(): array
    {
        if(empty($this->value)) {
            return [];
        }

        return [
            IntegerFilterForm::VALUE_FIELD => $this->value,
        ];
    }

    public function getValue(): ?string
    {
        return $this->value;
    }


}