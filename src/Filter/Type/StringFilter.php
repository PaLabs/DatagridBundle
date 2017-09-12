<?php

namespace PaLabs\DatagridBundle\Filter\Type;


use PaLabs\DatagridBundle\Filter\FilterHelper;
use PaLabs\DatagridBundle\Filter\FilterInterface;
use PaLabs\DatagridBundle\Filter\Form\TextFilterForm;
use Doctrine\ORM\QueryBuilder;

class StringFilter implements FilterInterface
{
    public function getDefaultFormType() {
        return TextFilterForm::class;
    }

    public function getDefaultFormOptions()
    {
        return [];
    }

    public function apply(QueryBuilder $qb, $name, $criteria, array $options = [])
    {
        if (empty($criteria['value'])) {
            return;
        }

        $fieldName = FilterHelper::fieldName($name, $options);
        $parameterName = FilterHelper::parameterName($name, $options);


        switch ($criteria['operator']) {
            case 'contains':
                $qb->andWhere(sprintf('%s LIKE :%s', $fieldName, $parameterName))
                    ->setParameter($parameterName, '%' . $criteria['value'] . '%');
                break;

        }
    }
}