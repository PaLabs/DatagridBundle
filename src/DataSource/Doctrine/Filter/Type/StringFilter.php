<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\DoctrineFilterInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;
use PaLabs\DatagridBundle\DataSource\Filter\Form\String\StringFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\String\StringFilterForm;

class StringFilter implements FilterFormProvider, DoctrineFilterInterface
{
    const OPERATOR_CONTAINS = 'c';
    const OPERATOR_NOT_CONTAINS = 'nc';
    const OPERATOR_EQUALS = 'e';

    public function formType(): string {
        return StringFilterForm::class;
    }

    public function formOptions(): array
    {
        return [];
    }

    public function apply(QueryBuilder $qb, string $name, $criteria, array $options = [])
    {
        if(!$criteria instanceof StringFilterData) {
            throw new \LogicException();
        }
        if (!$criteria->isEnabled()) {
            return;
        }

        $fieldName = FilterHelper::fieldName($name, $options);
        $parameterName = FilterHelper::parameterName($name, $options);


        switch ($criteria->getOperator()) {
            case self::OPERATOR_CONTAINS:
                $qb->andWhere(sprintf('%s LIKE :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, '%' . $criteria->getValue() . '%');
                break;
            case self::OPERATOR_NOT_CONTAINS:
                $qb->andWhere(sprintf('%s NOT LIKE :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, '%' . $criteria->getValue() . '%');
                break;
            case self::OPERATOR_EQUALS:
                $qb->andWhere(sprintf('%s = :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, $criteria->getValue());
                break;
            default:
                throw new \Exception(sprintf("Unknown operator: %s", $criteria->getValue()));

        }
    }
}