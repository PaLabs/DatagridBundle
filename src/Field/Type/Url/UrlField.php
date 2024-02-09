<?php

namespace PaLabs\DatagridBundle\Field\Type\Url;


use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Type\HtmlOrTextField;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;

class UrlField extends HtmlOrTextField
{
    public static function field(string $url = null, string $text = null, array $attr = [], array $options = []): UrlFieldData
    {
        return new UrlFieldData($url, $text, $attr, $options);
    }

    public function renderHtml(FieldData $data): string
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

    public function renderTxt(FieldData $data): string
    {
        if (!$data instanceof UrlFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        return is_string($data->getText()) ? htmlspecialchars($data->getText()) : $data->getText();
    }

    public function dataClass(): string
    {
        return UrlFieldData::class;
    }
}