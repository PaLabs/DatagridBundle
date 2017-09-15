<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\Filter\FilterInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\Boolean\BooleanFilterForm;
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

        if ($criteria['value'] === null) {
            return;
        }
        $value = $criteria['value'] == 0 ? false : true;

        $fieldName = FilterHelper::fieldName($name, $options);

        if ($value) {
            $qb->andWhere(sprintf('%s IS NOT NULL', $fieldName));
        } else {
            $qb->andWhere(sprintf('%s IS NULL', $fieldName));
        }
    }

}