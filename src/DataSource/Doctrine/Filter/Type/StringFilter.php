<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use Doctrine\ORM\QueryBuilder;
use Exception;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\DoctrineFilterInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;
use PaLabs\DatagridBundle\DataSource\Filter\Form\String\StringFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\String\StringFilterForm;
use PaLabs\DatagridBundle\DataSource\Filter\Form\String\StringFilterOperator;
use PaLabs\DatagridBundle\DataSource\Filter\InvalidFilterDataException;
use PaLabs\DatagridBundle\DataSource\Filter\Options\BaseFilterOptions;

class StringFilter implements FilterFormProvider, DoctrineFilterInterface
{

    public static function data(string $operator, ?string $value = null): StringFilterData
    {
        return new StringFilterData($operator, $value);
    }

    public static function options(string $label): BaseFilterOptions
    {
        return new BaseFilterOptions($label);
    }

    public function formType(): string
    {
        return StringFilterForm::class;
    }

    public function formOptions(): array
    {
        return [];
    }

    public function apply(QueryBuilder $qb, string $name, $criteria, array $options = [])
    {
        if (!$criteria instanceof StringFilterData) {
            throw new InvalidFilterDataException(StringFilterData::class, $criteria);
        }
        if (!$criteria->isEnabled()) {
            return;
        }

        $fieldName = FilterHelper::fieldName($name, $options);
        $parameterName = FilterHelper::parameterName($name);


        switch ($criteria->getOperator()) {
            case StringFilterOperator::OPERATOR_CONTAINS:
                $qb->andWhere(sprintf('%s LIKE :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, '%' . $criteria->getValue() . '%');
                break;
            case StringFilterOperator::OPERATOR_NOT_CONTAINS:
                $qb->andWhere(sprintf('%s NOT LIKE :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, '%' . $criteria->getValue() . '%');
                break;
            case StringFilterOperator::OPERATOR_EQUALS:
                $qb->andWhere(sprintf('%s = :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, $criteria->getValue());
                break;
            case StringFilterOperator::OPERATOR_EMPTY:
                $qb->andWhere(sprintf('%s IS NULL', $fieldName));
                break;
            case StringFilterOperator::OPERATOR_NOT_EMPTY:
                $qb->andWhere(sprintf('%s IS NOT NULL', $fieldName));
                break;
            default:
                throw new Exception(sprintf("Unknown operator: %s", $criteria->getValue()));

        }
    }
}