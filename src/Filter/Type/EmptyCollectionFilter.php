<?php

namespace PaLabs\DatagridBundle\Filter\Type;


use PaLabs\DatagridBundle\Filter\FilterHelper;
use PaLabs\DatagridBundle\Filter\FilterInterface;
use PaLabs\DatagridBundle\Filter\Form\BooleanFilterForm;
use Doctrine\ORM\QueryBuilder;

class EmptyCollectionFilter implements FilterInterface
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
        $value = $criteria['value'] == 0 ? false : true;

        $fieldName = FilterHelper::fieldName($name, $options);

        if ($value) {
            $qb->andWhere(sprintf('%s IS NOT EMPTY', $fieldName));
        } else {
            $qb->andWhere(sprintf('%s IS EMPTY', $fieldName));
        }
    }

}