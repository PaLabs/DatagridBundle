<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


use DateTime;
use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class DateFilterData implements FilterDataInterface
{
    protected DateFilterOperator $period;
    protected ?DateTime $startDate;
    protected ?DateTime $endDate;

    public function __construct(
        DateFilterOperator $period,
        ?DateTime $startDate = null,
        ?DateTime $endDate = null)
    {
        $this->period = $period;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
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
            DateFilterForm::PERIOD_FIELD => $this->period->name(),
            DateFilterForm::START_FIELD => $this->startDate,
            DateFilterForm::END_FIELD => $this->endDate
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