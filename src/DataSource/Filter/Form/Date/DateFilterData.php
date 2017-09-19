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

    /**
     * @return \DateTime|null
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndDate()
    {
        return $this->endDate;
    }


}