<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use DateTime;
use Doctrine\ORM\QueryBuilder;
use Exception;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\DoctrineFilterInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\FilterHelper;
use PaLabs\DatagridBundle\DataSource\Filter\FilterFormProvider;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Date\DateFilterData;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Date\DateFilterForm;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Date\DateFilterOperator;
use PaLabs\DatagridBundle\DataSource\Filter\InvalidFilterDataException;
use PaLabs\DatagridBundle\DataSource\Filter\Options\BaseFilterOptions;

class DateFilter implements FilterFormProvider, DoctrineFilterInterface
{

    public static function data(DateFilterOperator $period, ?DateTime $startDate = null, ?DateTime $endDate = null): DateFilterData
    {
        return new DateFilterData($period, $startDate, $endDate);
    }

    public static function options(string $label): BaseFilterOptions
    {
        return new BaseFilterOptions($label);
    }

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
        $parameterName = FilterHelper::parameterName($name);

        switch ($criteria->getPeriod()) {
            case DateFilterOperator::$OPERATOR_CURRENT_DAY:
                $this->applyPeriod($qb, $fieldName, $parameterName, (new DateTime('today')));
                break;
            case DateFilterOperator::$OPERATOR_YESTERDAY:
                $this->applyPeriod($qb, $fieldName, $parameterName, (new DateTime('yesterday')));
                break;
            case DateFilterOperator::$OPERATOR_CURRENT_WEEK:
                $this->applyPeriod($qb, $fieldName, $parameterName, (new DateTime('this week')));
                break;
            case DateFilterOperator::$OPERATOR_CURRENT_YEAR:
                $this->applyPeriod($qb, $fieldName, $parameterName,
                    (new DateTime(sprintf('first day of january %d', (new DateTime())->format('Y')))));
                break;
            case DateFilterOperator::$OPERATOR_INTERVAL:
                $this->applyInterval($qb, $criteria, $fieldName, $parameterName);
                break;
            default:
                throw new Exception(sprintf("Unknown date filter operator: %s", $criteria->getPeriod()));

        }

    }

    private function applyPeriod(QueryBuilder $qb, string $fieldName, string $parameterName, DateTime $startDate): void
    {
        $qb->andWhere(sprintf('%s >= :%s', $fieldName, $parameterName))
            ->setParameter($parameterName, $startDate);
    }

    private function applyInterval(QueryBuilder $qb, DateFilterData $criteria, string $fieldName, string $parameterName): void
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

}