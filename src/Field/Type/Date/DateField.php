<?php

namespace PaLabs\DatagridBundle\Field\Type\Date;


use DateTime;
use IntlDateFormatter;
use Locale;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Type\HtmlOrTextField;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;

class DateField extends HtmlOrTextField
{
    public static function field(?DateTime $dateTime = null, ?string $locale = null, array $options = []): DateFieldData
    {
        return new DateFieldData($dateTime, $locale, $options);
    }

    public function renderHtml(FieldData $data): string
    {
        if (!$data instanceof DateFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        if($data->getDateTime() === null) {
            return '';
        }

        $locale = $data->getLocale() ?? Locale::getDefault();
        return IntlDateFormatter::create($locale, IntlDateFormatter::MEDIUM, IntlDateFormatter::NONE)
            ->format($data->getDateTime());
    }

    public function renderTxt(FieldData $data): string
    {
        return $this->renderHtml($data);
    }

    public function dataClass(): string
    {
        return DateFieldData::class;
    }
}