<?php

namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\FieldCheckDataTrait;
use PaLabs\DatagridBundle\Field\HtmlOrTextField;

class StringField extends HtmlOrTextField
{
    use FieldCheckDataTrait;

    public static function field(string $value = null, array $renderOptions = [], array $options = [])
    {
        return new StringFieldData($value ?? '', $renderOptions, $options);
    }

    public function renderHtml(FieldData $data)
    {
        $this->checkDataType($data, $this->dataClass());
        /** @var StringFieldData $data */

        $result = is_string($data->getValue()) ? htmlspecialchars($data->getValue()) : $data->getValue();

        $options = $data->getRenderOptions();
        if (isset($options['bold']) && $options['bold'] === true) {
            $result = '<b>' . $result . '</b>';
        }
        return $result;
    }

    public function renderTxt(FieldData $data)
    {
        $this->checkDataType($data, $this->dataClass());
        /** @var StringFieldData $data */

        return $data->getValue();
    }

    public function dataClass(): string
    {
        return StringFieldData::class;
    }
}