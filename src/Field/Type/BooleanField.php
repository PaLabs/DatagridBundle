<?php

namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\FieldRenderUtils;
use PaLabs\DatagridBundle\Field\FieldCheckDataTrait;
use PaLabs\DatagridBundle\Field\HtmlOrTextField;

class BooleanField extends HtmlOrTextField
{
    use FieldCheckDataTrait;

   public static function field(bool $value, array $options = [])
    {
        return new BooleanFieldData($value, $options);
    }

    public function renderHtml(FieldData $data)
    {
        $this->checkDataType($data, $this->dataClass());
        /** @var BooleanFieldData $data */

        return FieldRenderUtils::renderBoolLabel($data->getValue());
    }

    public function renderTxt(FieldData $data)
    {
        $this->checkDataType($data, $this->dataClass());
        /** @var BooleanFieldData $data */

        return ($data->getValue() === true) ? 'Да' : 'Нет';
    }

    public function dataClass(): string
    {
        return BooleanFieldData::class;
    }
}