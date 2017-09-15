<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\Date;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\Filter\FilterInterface;

class DateFilter implements FilterInterface
{
    public function formType(): string
    {
        return DateFilterForm::class;
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

        $fieldName = FilterHelper::fieldName($name, $options);
        $parameterName = FilterHelper::parameterName($name, $options);

        if (!empty($criteria['start'])) {
            $criteriaParameterName = $parameterName . '_start_date';
            $qb->andWhere(sprintf('%s >= :%s', $fieldName, $criteriaParameterName))
                ->setParameter($criteriaParameterName, $criteria['start']);
        }
        if (!empty($criteria['end'])) {
            $criteriaParameterName = $parameterName . '_end_date';
            $qb->andWhere(sprintf('%s <= :%s', $fieldName, $criteriaParameterName))
                ->setParameter($criteriaParameterName, $criteria['end']);
        }
    }

}