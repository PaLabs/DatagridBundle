<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\EntityFilter;
use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class EntityFilterData implements FilterDataInterface
{
    /** @var  string */
    protected $operator;

    /** @var  EntityInterface */
    protected $value;

    public function __construct(string $operator, $value = null)
    {
        $this->operator = $operator;
        $this->value = $value;
    }

    public function isEnabled(): bool {
        if(in_array($this->operator, [EntityFilter::OPERATOR_EMPTY, EntityFilter::OPERATOR_NOT_EMPTY])) {
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
            EntityFilterForm::VALUE_FIELD => $this->value->getId()
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