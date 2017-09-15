<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\Entity;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\Filter\FilterInterface;

class EntityFilter implements FilterInterface
{
    const OPERATOR_EQUALS = 'equals';
    const OPERATOR_NOT_EQUALS = 'not_equals';

    public static function formData($value, $operator = self::OPERATOR_EQUALS)
    {
        return [
            EntityFilterForm::OPERATOR_FIELD => $operator,
            EntityFilterForm::VALUE_FIELD => $value->getId()
        ];
    }

    public function formType(): string
    {
        return EntityFilterForm::class;
    }

    public function formOptions(): array
    {
        return [];
    }

    public function apply($qb, string $name, $criteria, array $options = [])
    {
        if(!$qb instanceof QueryBuilder) {
            throw new \Exception("This filter can only be applies to QueryBuilder");
        }

        if (empty($criteria[EntityFilterForm::VALUE_FIELD])) {
            return;
        }

        $fieldName = FilterHelper::fieldName($name, $options);
        $parameterName = FilterHelper::parameterName($name, $options);

        switch ($criteria[EntityFilterForm::OPERATOR_FIELD]) {
            case self::OPERATOR_EQUALS:
                $qb->andWhere(sprintf('%s = :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, $criteria[EntityFilterForm::VALUE_FIELD]);
                break;
            case self::OPERATOR_NOT_EQUALS:
                $qb->andWhere(sprintf('%s != :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, $criteria[EntityFilterForm::VALUE_FIELD]);
                break;
        }
    }
}