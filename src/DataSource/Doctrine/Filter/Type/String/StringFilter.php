<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\String;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\Filter\FilterInterface;

class StringFilter implements FilterInterface
{
    public function formType(): string {
        return StringFilterForm::class;
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