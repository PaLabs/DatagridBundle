<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\DoctrineFilterInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Entity\EntityFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Entity\EntityFilterForm;
use PaLabs\DatagridBundle\DataSource\Filter\InvalidFilterDataException;

class EntityFilter implements FilterFormProvider, DoctrineFilterInterface
{
    const OPERATOR_EQUALS = 'e';
    const OPERATOR_NOT_EQUALS = 'ne';

    public function formType(): string
    {
        return EntityFilterForm::class;
    }

    public function formOptions(): array
    {
        return [];
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
        $parameterName = FilterHelper::parameterName($name, $options);

        switch ($criteria->getOperator()) {
            case self::OPERATOR_EQUALS:
                $qb->andWhere(sprintf('%s = :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, $criteria->getValue());
                break;
            case self::OPERATOR_NOT_EQUALS:
                $qb->andWhere(sprintf('%s != :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, $criteria->getValue());
                break;
            default:
                throw new \Exception(sprintf("Unknown operator: %s", $criteria->getOperator()));
        }
    }
}