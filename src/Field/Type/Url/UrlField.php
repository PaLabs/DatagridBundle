<?php

namespace PaLabs\DatagridBundle\Field\Type\Url;


use PaLabs\DatagridBundle\Field\Type\FieldCheckDataTrait;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Type\HtmlOrTextField;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;
use PaLabs\DatagridBundle\Field\Type\PaLabs;
use PaLabs\DatagridBundle\Field\Type\Url\UrlFieldData;

class UrlField extends HtmlOrTextField
{
    public static function field($url, $text, $attr = [], $options = [])
    {
        return new UrlFieldData($url, $text, $attr, $options);
    }

    public function renderHtml(FieldData $data)
    {
        if (!$data instanceof UrlFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

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
        if (!$data instanceof UrlFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        $text = is_string($data->getText()) ? htmlspecialchars($data->getText()) : $data->getText();
        return $text;
    }

    public function dataClass(): string
    {
        return UrlFieldData::class;
    }
}