<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\DoctrineFilterInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Entity\EntityFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Entity\EntityFilterForm;
use PaLabs\DatagridBundle\DataSource\Filter\InvalidFilterDataException;
use PaLabs\DatagridBundle\DataSource\Filter\Options\BaseFilterOptions;
use PaLabs\DatagridBundle\DataSource\Filter\Options\FilterOptions;

class EntityFilter implements FilterFormProvider, DoctrineFilterInterface
{
    const OPERATOR_EQUALS = 'e';
    const OPERATOR_NOT_EQUALS = 'ne';
    const OPERATOR_EMPTY = 'em';
    const OPERATOR_NOT_EMPTY = 'nem';

    public function formType(): string
    {
        return EntityFilterForm::class;
    }

    public function formOptions(): array
    {
        return [];
    }

    public static function options(string $label): FilterOptions {
        return new EntityFilterOptions($label);
    }

    public function apply(QueryBuilder $qb, string $name, $criteria, array $options = [])
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
            case self::OPERATOR_EQUALS:
                $qb->andWhere(sprintf('%s = :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, $criteria->getValue());
                break;
            case self::OPERATOR_NOT_EQUALS:
                $qb->andWhere(sprintf('%s != :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, $criteria->getValue());
                break;
            case self::OPERATOR_EMPTY:
                $qb->andWhere(sprintf('%s IS NULL', $fieldName));
                break;
            case self::OPERATOR_NOT_EMPTY:
                $qb->andWhere(sprintf('%s IS NOT NULL', $fieldName));
                break;
            default:
                throw new \Exception(sprintf("Unknown operator: %s", $criteria->getOperator()));
        }
    }
}