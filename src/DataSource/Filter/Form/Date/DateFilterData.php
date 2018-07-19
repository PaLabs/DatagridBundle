<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;

class DateFilterData implements FilterDataInterface
{
    /** @var  \DateTime */
    protected $startDate;

    /** @var  \DateTime */
    protected $endDate;

    public function __construct(\DateTime $startDate = null, \DateTime $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function isEnabled(): bool {
        return $this->startDate !== null || $this->endDate !== null;
    }

    public function toUrlParams(): array
    {
        return [
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


}