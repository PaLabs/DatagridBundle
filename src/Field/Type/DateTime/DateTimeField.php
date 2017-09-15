<?php


namespace PaLabs\DatagridBundle\Field\Type\DateTime;


use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Type\DateTime\DateTimeFieldData;
use PaLabs\DatagridBundle\Field\Type\FieldCheckDataTrait;
use PaLabs\DatagridBundle\Field\Type\HtmlOrTextField;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;
use PaLabs\DatagridBundle\Field\Type\PaLabs;
use PaLabs\DatagridBundle\Util\DateUtils;

class DateTimeField extends HtmlOrTextField
{
    public static function field(\DateTime $dateTime, string $locale = 'en', array $options = [])
    {
        return new DateTimeFieldData($dateTime, $locale, $options);
    }

    public function renderHtml(FieldData $data)
    {
        if (!$data instanceof DateTimeFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        return \IntlDateFormatter::create($data->getLocale(), \IntlDateFormatter::MEDIUM, \IntlDateFormatter::MEDIUM)
            ->format($data->getDateTime());
    }

    public function renderTxt(FieldData $data)
    {
        return $this->renderHtml($data);
    }

    public function dataClass(): string
    {
        return DateTimeFieldData::class;
    }
}