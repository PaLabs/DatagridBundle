<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\DoctrineFilterInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Date\DateFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Date\DateFilterForm;
use PaLabs\DatagridBundle\DataSource\Filter\InvalidFilterDataException;

class DateFilter implements FilterFormProvider, DoctrineFilterInterface
{
    const OPERATOR_INTERVAL = 'i';
    const OPERATOR_CURRENT_DAY = 'cd';
    const OPERATOR_YESTERDAY = 'yd';
    const OPERATOR_CURRENT_WEEK = 'cw';
    const OPERATOR_CURRENT_YEAR = 'cy';

    const PERIOD_OPERATORS = [
        self::OPERATOR_CURRENT_DAY,
        self::OPERATOR_YESTERDAY,
        self::OPERATOR_CURRENT_WEEK,
        self::OPERATOR_CURRENT_YEAR
    ];

    public function formType(): string
    {
        return DateFilterForm::class;
    }


    public function formOptions(): array
    {
        return [];
    }

    public function apply(QueryBuilder $qb, string $name, $criteria, array $options = [])
    {
        if (!$criteria instanceof DateFilterData) {
            throw new InvalidFilterDataException(DateFilterData::class, $criteria);
        }
        if (!$criteria->isEnabled()) {
            return;
        }

        $fieldName = FilterHelper::fieldName($name, $options);
        $parameterName = FilterHelper::parameterName($name, $options);

        switch ($criteria->getPeriod()) {
            case DateFilter::OPERATOR_CURRENT_DAY:
                return $this->applyPeriod($qb, $fieldName, $parameterName, (new \DateTime('today')));
            case DateFilter::OPERATOR_YESTERDAY:
                return $this->applyPeriod($qb, $fieldName, $parameterName, (new \DateTime('yesterday')));
            case DateFilter::OPERATOR_CURRENT_WEEK:
                return $this->applyPeriod($qb, $fieldName, $parameterName, (new \DateTime('this week')));
            case DateFilter::OPERATOR_CURRENT_YEAR:
                return $this->applyPeriod($qb, $fieldName, $parameterName,
                    (new \DateTime(sprintf('first day of january %d', (new \DateTime())->format('Y')))));
            case DateFilter::OPERATOR_INTERVAL:
                return $this->applyInterval($qb, $criteria, $fieldName, $parameterName);
            default:
                throw new \Exception(sprintf("Unknown date filter operator: %s", $criteria->getPeriod()));

        }

    }

    private function applyInterval(QueryBuilder $qb, DateFilterData $criteria, string $fieldName, string $parameterName)
    {
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

    private function applyPeriod(QueryBuilder $qb, string $fieldName, string $parameterName, \DateTime $startDate)
    {
        $qb->andWhere(sprintf('%s >= :%s', $fieldName, $parameterName))
            ->setParameter($parameterName, $startDate);
    }

}