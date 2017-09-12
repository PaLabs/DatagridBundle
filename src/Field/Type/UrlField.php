<?php

namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\FieldCheckDataTrait;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\HtmlOrTextField;

class UrlField extends HtmlOrTextField
{
    use FieldCheckDataTrait;

    public static function field($url, $text, $attr = [], $options = [])
    {
        return new UrlFieldData($url, $text, $attr, $options);
    }

    public function renderHtml(FieldData $data)
    {
        $this->checkDataType($data, $this->dataClass());
        /** @var UrlFieldData  $data */

        $url = $data->getUrl();
        $text = is_string($data->getText()) ? htmlspecialchars($data->getText()) : $data->getText();

        if (empty($url)) {
            return $text;
        }
        $attr = ['href' => $url];
            $attr = array_merge($attr, $data->getAttr());

            $attrStr = implode(' ', array_map(function ($key) use ($attr) {
            return sprintf('%s="%s"', $key, $attr[$key]);
        }, array_keys($attr)));

        return "<a $attrStr>$text</a>";
    }

    public function renderTxt(FieldData $data)
    {
        $this->checkDataType($data, $this->dataClass());
        /** @var UrlFieldData  $data */

        $text = is_string($data->getText()) ? htmlspecialchars($data->getText()) : $data->getText();
        return $text;
    }

    public function dataClass(): string
    {
        return UrlFieldData::class;
    }
}