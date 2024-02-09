<?php

namespace PaLabs\DatagridBundle\Field\Type\String;


use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Type\HtmlOrTextField;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;

class StringField extends HtmlOrTextField
{
    public static function field(string $value = null, array $renderOptions = [], array $options = []): StringFieldData
    {
        return new StringFieldData($value ?? '', $renderOptions, $options);
    }

    public function renderHtml(FieldData $data): string
    {
        if (!$data instanceof StringFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        if(empty($data->getValue())) {
            return '';
        }

        $result = htmlspecialchars($data->getValue());

        $options = $data->getRenderOptions();
        if (isset($options['bold']) && $options['bold'] === true) {
            $result = '<b>' . $result . '</b>';
        }
        return $result;
    }

    public function renderTxt(FieldData $data): string
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