<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterInterface;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Boolean\BooleanFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Boolean\BooleanFilterForm;
use Doctrine\ORM\QueryBuilder;

class IsNullFilter implements FilterInterface
{
    public function formType(): string
    {
        return BooleanFilterForm::class;
    }

    public function formOptions(): array
    {
        return [];
    }

    public function apply($qb, string $name, $criteria, array $options = [])
    {
        if(!$qb instanceof QueryBuilder) {
            throw new \Exception("This filter can only be applies to QueryBuilder");
        }
        if(!$criteria instanceof BooleanFilterData) {
            throw new \Exception();
        }
        if (!$criteria->isEnabled()) {
            return;
        }


        $fieldName = FilterHelper::fieldName($name, $options);

        if ($criteria->getValue()) {
            $qb->andWhere(sprintf('%s IS NOT NULL', $fieldName));
        } else {
            $qb->andWhere(sprintf('%s IS NULL', $fieldName));
        }
    }

}