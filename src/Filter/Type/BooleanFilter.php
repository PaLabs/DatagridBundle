<?php

namespace PaLabs\DatagridBundle\Filter\Type;


use PaLabs\DatagridBundle\Filter\FilterHelper;
use PaLabs\DatagridBundle\Filter\FilterInterface;
use PaLabs\DatagridBundle\Filter\Form\BooleanFilterForm;
use Doctrine\ORM\QueryBuilder;

class BooleanFilter implements FilterInterface
{
    public function getDefaultFormType()
    {
        return BooleanFilterForm::class;
    }

    public function getDefaultFormOptions()
    {
        return [];
    }

    public function apply(QueryBuilder $qb, $name, $criteria, array $options = [])
    {
        if ($criteria['value'] === null) {
            return;
        }

        $fieldName = FilterHelper::fieldName($name, $options);
        $parameterName = FilterHelper::parameterName($name, $options);

        $value = $criteria['value'] == 0 ? false : true;
        $qb->andWhere(sprintf('%s = :%s', $fieldName, $parameterName))
            ->setParameter($parameterName, $value);
    }


}