<?php

namespace PaLabs\DatagridBundle\Field\Type\String;


use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Type\FieldCheckDataTrait;
use PaLabs\DatagridBundle\Field\Type\HtmlOrTextField;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;
use PaLabs\DatagridBundle\Field\Type\PaLabs;
use PaLabs\DatagridBundle\Field\Type\String\StringFieldData;

class StringField extends HtmlOrTextField
{
    public static function field(string $value = '', array $renderOptions = [], array $options = [])
    {
        return new StringFieldData($value, $renderOptions, $options);
    }

    public function renderHtml(FieldData $data)
    {
        if (!$data instanceof StringFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        $result = htmlspecialchars($data->getValue());

        $options = $data->getRenderOptions();
        if (isset($options['bold']) && $options['bold'] === true) {
            $result = '<b>' . $result . '</b>';
        }
        return $result;
    }

    public function renderTxt(FieldData $data)
    {
        if (!$data instanceof StringFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        return $data->getValue();
    }

    public function dataClass(): string
    {
        return StringFieldData::class;
    }
}