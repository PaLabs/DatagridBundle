<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


use DateTime;
use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class DateFilterData implements FilterDataInterface
{

    public function __construct(
        protected DateFilterOperator $period,
        protected ?DateTime $startDate = null,
        protected ?DateTime $endDate = null)
    {
    }

    public function isEnabled(): bool
    {
        if (DateFilterOperators::getInstance()->isPeriodOperator($this->period)) {
            return true;
        }
        return $this->startDate !== null || $this->endDate !== null;
    }

    public function toUrlParams(): array
    {
        return [
            DateFilterForm::PERIOD_FIELD => $this->period->value,
            DateFilterForm::START_FIELD => $this->startDate?->format('Y-m-d'),
            DateFilterForm::END_FIELD => $this->endDate?->format('Y-m-d')
        ];
    }

    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): ?DateTime
    {
        return $this->endDate;
    }

    public function getPeriod(): DateFilterOperator
    {
        return $this->period;
    }

}