<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


use DateTime;
use LogicException;
use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class DateFilterData implements FilterDataInterface
{
    protected string $period;
    protected ?DateTime $startDate;
    protected ?DateTime $endDate;

    public function __construct(
        string $period,
        ?DateTime $startDate = null,
        ?DateTime $endDate = null)
    {
        if (!DateFilterOperator::valid($period)) {
            throw new LogicException(sprintf('DateFilter operator %s is not a valid operator', $period));
        }
        $this->period = $period;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function isEnabled(): bool
    {
        if (in_array($this->period, DateFilterOperator::PERIOD_OPERATORS)) {
            return true;
        }
        return $this->startDate !== null || $this->endDate !== null;
    }

    public function toUrlParams(): array
    {
        return [
            DateFilterForm::PERIOD_FIELD => $this->period,
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

    public function getPeriod(): string
    {
        return $this->period;
    }

}