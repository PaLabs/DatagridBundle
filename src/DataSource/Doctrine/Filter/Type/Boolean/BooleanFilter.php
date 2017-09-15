<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\Boolean;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\Filter\FilterInterface;

class BooleanFilter implements FilterInterface
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

        $fieldName = FilterHelper::fieldName($name, $options);
        $parameterName = FilterHelper::parameterName($name, $options);

        $value = $criteria['value'] == 0 ? false : true;
        $qb->andWhere(sprintf('%s = :%s', $fieldName, $parameterName))
            ->setParameter($parameterName, $value);
    }


}