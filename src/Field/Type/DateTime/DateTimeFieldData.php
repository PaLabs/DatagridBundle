<?php


namespace PaLabs\DatagridBundle\Field\Type\DateTime;


use PaLabs\DatagridBundle\Field\Type\BaseFieldData;

class DateTimeFieldData extends BaseFieldData
{
    protected $dateTime;
    protected $locale;

    public function __construct(\DateTime $date = null, string $locale = 'en', array $options = [])
    {
        parent::__construct($options);
        $this->dateTime = $date;
        $this->locale = $locale;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }


}