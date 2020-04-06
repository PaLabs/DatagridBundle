<?php


namespace PaLabs\DatagridBundle\Field\Type\Date;


use DateTime;
use PaLabs\DatagridBundle\Field\Type\BaseFieldData;

class DateFieldData extends BaseFieldData
{
    protected ?DateTime $dateTime;
    protected string $locale;

    public function __construct(?DateTime $date = null, string $locale = 'en', array $options = [])
    {
        parent::__construct($options);
        $this->dateTime = $date;
        $this->locale = $locale;
    }

    public function getDateTime(): ?DateTime
    {
        return $this->dateTime;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }


}