<?php

namespace PaLabs\DatagridBundle\Field\Type\Date;


use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Type\HtmlOrTextField;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;

class DateField extends HtmlOrTextField
{
    public static function field(\DateTime $dateTime = null, string $locale = 'en', array $options = [])
    {
        return new DateFieldData($dateTime, $locale, $options);
    }

    public function renderHtml(FieldData $data)
    {
        if (!$data instanceof DateFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        if($data->getDateTime() === null) {
            return '';
        }

        return \IntlDateFormatter::create($data->getLocale(), \IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE)
            ->format($data->getDateTime());
    }

    public function renderTxt(FieldData $data)
    {
        return $this->renderHtml($data);
    }

    public function dataClass(): string
    {
        return DateFieldData::class;
    }
}