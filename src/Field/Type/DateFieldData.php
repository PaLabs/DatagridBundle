<?php


namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\BaseFieldData;

class DateFieldData extends BaseFieldData
{
    protected $dateTime;

    public function __construct(\DateTime $date, array $options = [])
    {
        parent::__construct($options);
        $this->dateTime = $date;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }


}