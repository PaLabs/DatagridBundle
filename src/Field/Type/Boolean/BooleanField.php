<?php

namespace PaLabs\DatagridBundle\Field\Type\Boolean;


use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Renderer\FieldRenderUtils;
use PaLabs\DatagridBundle\Field\Type\HtmlOrTextField;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;

class BooleanField extends HtmlOrTextField
{
    public static function field(bool $value, array $options = [])
    {
        return new BooleanFieldData($value, $options);
    }

    public function renderHtml(FieldData $data)
    {
        if (!$data instanceof BooleanFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        return FieldRenderUtils::renderBoolLabel($data->getValue());
    }

    public function renderTxt(FieldData $data)
    {
        if (!$data instanceof BooleanFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        return ($data->getValue() === true) ? 'Да' : 'Нет';
    }

    public function dataClass(): string
    {
        return BooleanFieldData::class;
    }
}