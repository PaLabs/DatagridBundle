<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\DateFilter;
use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class DateFilterData implements FilterDataInterface
{
    /** @var string */
    protected $period;

    /** @var  \DateTime */
    protected $startDate;

    /** @var  \DateTime */
    protected $endDate;

    public function __construct(string $period, \DateTime $startDate = null, \DateTime $endDate = null)
    {
        $this->period = $period;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function isEnabled(): bool {
        if(in_array($this->period, [DateFilter::OPERATOR_CURRENT_DAY, DateFilter::OPERATOR_CURRENT_YEAR])) {
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

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

}