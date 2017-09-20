<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\DoctrineFilterInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Boolean\BooleanFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Boolean\BooleanFilterForm;
use Doctrine\ORM\QueryBuilder;

class IsNullFilter implements FilterFormProvider, DoctrineFilterInterface
{
    public function formType(): string
    {
        return BooleanFilterForm::class;
    }

    public function formOptions(): array
    {
        return [];
    }

    public function apply(QueryBuilder $qb, string $name, $criteria, array $options = [])
    {
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