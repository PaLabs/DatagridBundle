<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterInterface;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Entity\EntityFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Entity\EntityFilterForm;

class EntityFilter implements FilterInterface
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

    public function apply($qb, string $name, $criteria, array $options = [])
    {
        if (!$qb instanceof QueryBuilder) {
            throw new \Exception("This filter can only be applies to QueryBuilder");
        }
        if (!$criteria instanceof EntityFilterData) {
            throw new \Exception();
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