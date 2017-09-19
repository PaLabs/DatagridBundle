<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterInterface;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Date\DateFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Date\DateFilterForm;

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
        if (!$criteria instanceof DateFilterData) {
            throw new \Exception();
        }
        if (!$criteria->isEnabled()) {
            return;
        }

        $fieldName = FilterHelper::fieldName($name, $options);
        $parameterName = FilterHelper::parameterName($name, $options);

        if ($criteria->getStartDate() !== null) {
            $criteriaParameterName = $parameterName . '_start_date';
            $qb->andWhere(sprintf('%s >= :%s', $fieldName, $criteriaParameterName))
                ->setParameter($criteriaParameterName, $criteria->getStartDate());
        }
        if ($criteria->getEndDate() !== null) {
            $criteriaParameterName = $parameterName . '_end_date';
            $qb->andWhere(sprintf('%s <= :%s', $fieldName, $criteriaParameterName))
                ->setParameter($criteriaParameterName, $criteria->getEndDate());
        }
    }

}