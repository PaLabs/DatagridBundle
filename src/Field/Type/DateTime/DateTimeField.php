<?php


namespace PaLabs\DatagridBundle\Field\Type\DateTime;


use DateTime;
use IntlDateFormatter;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Type\HtmlOrTextField;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;

class DateTimeField extends HtmlOrTextField
{
    public static function field(?DateTime $dateTime = null, string $locale = 'en', array $options = []): DateTimeFieldData
    {
        return new DateTimeFieldData($dateTime, $locale, $options);
    }

    public function renderHtml(FieldData $data): string
    {
        if (!$data instanceof DateTimeFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        if($data->getDateTime() === null) {
            return '';
        }

        return IntlDateFormatter::create($data->getLocale(), IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM)
            ->format($data->getDateTime());
    }

    public function renderTxt(FieldData $data): string
    {
        return $this->renderHtml($data);
    }

    public function dataClass(): string
    {
        return DateTimeFieldData::class;
    }
}