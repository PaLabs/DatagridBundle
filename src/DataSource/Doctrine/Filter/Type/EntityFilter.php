<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use Doctrine\ORM\QueryBuilder;
use Exception;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\DoctrineFilterInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Entity\EntityFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Entity\EntityFilterForm;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Entity\EntityFilterOperator;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Entity\EntityFilterOptions;
use PaLabs\DatagridBundle\DataSource\Filter\InvalidFilterDataException;

class EntityFilter implements FilterFormProvider, DoctrineFilterInterface
{

    public static function data($value = null, ?EntityFilterOperator $operator = null): EntityFilterData
    {
        return new EntityFilterData($operator ?? EntityFilterOperator::OPERATOR_EQUALS, $value);
    }

    public static function options(string $label): EntityFilterOptions
    {
        return new EntityFilterOptions($label);
    }

    public function formType(): string
    {
        return EntityFilterForm::class;
    }

    public function formOptions(): array
    {
        return [];
    }

    public function apply(QueryBuilder $qb, string $name, $criteria, array $options = []): void
    {
        if (!$criteria instanceof EntityFilterData) {
            throw new InvalidFilterDataException(EntityFilterData::class, $criteria);
        }
        if (!$criteria->isEnabled()) {
            return;
        }

        $fieldName = FilterHelper::fieldName($name, $options);
        $parameterName = FilterHelper::parameterName($name);

        switch ($criteria->getOperator()) {
            case EntityFilterOperator::OPERATOR_EQUALS:
                $qb->andWhere(sprintf('%s = :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, $criteria->getValue());
                break;
            case EntityFilterOperator::OPERATOR_NOT_EQUALS:
                $qb->andWhere(sprintf('%s != :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, $criteria->getValue());
                break;
            case EntityFilterOperator::OPERATOR_EMPTY:
                $qb->andWhere(sprintf('%s IS NULL', $fieldName));
                break;
            case EntityFilterOperator::OPERATOR_NOT_EMPTY:
                $qb->andWhere(sprintf('%s IS NOT NULL', $fieldName));
                break;
            default:
                throw new Exception(sprintf("Unknown operator: %s", $criteria->getOperator()));
        }
    }
}