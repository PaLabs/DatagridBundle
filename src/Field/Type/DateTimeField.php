<?php


namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\FieldCheckDataTrait;
use PaLabs\DatagridBundle\Field\HtmlOrTextField;
use PaLabs\DatagridBundle\Util\DateUtils;

class DateTimeField extends HtmlOrTextField
{
    use FieldCheckDataTrait;

    public static function field(\DateTime $dateTime, array $options = [])
    {
        return new DateTimeFieldData($dateTime, $options);
    }

    public function renderHtml(FieldData $data)
    {
        $this->checkDataType($data, $this->dataClass());
        /** @var DateTimeFieldData $data */

        return DateUtils::localizedDateTime($data->getDateTime());
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