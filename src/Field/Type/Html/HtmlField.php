<?php


namespace PaLabs\DatagridBundle\Field\Type\Html;


use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;
use PaLabs\DatagridBundle\Grid\Export\XlsxExporter;
use PaLabs\DatagridBundle\Grid\GridOptions;
use PhpOffice\PhpSpreadsheet\Helper\Html;

class HtmlField implements Field
{
    public static function field(string $value = '', array $options = [])
    {
        return new HtmlFieldData($value, $options);
    }

    public function render(FieldData $data, String $format)
    {
        switch ($format) {
            case GridOptions::RENDER_FORMAT_HTML:
                return $this->renderHtml($data);
            case XlsxExporter::FORMAT:
                return $this->renderXlxs($data);
            default:
                return $this->renderTxt($data);
        }
    }

    public function renderHtml(FieldData $data)
    {
        if (!$data instanceof HtmlFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        return $data->getValue();
    }

    public function renderTxt(FieldData $data)
    {
        if (!$data instanceof HtmlFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        $value = $data->getValue();
        $value = strip_tags($value);
        return $value;
    }

    public function dataClass(): string
    {
        return HtmlFieldData::class;
    }

    private function renderXlxs(FieldData $data)
    {
        if (!$data instanceof HtmlFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }
        $wizard = new Html();
        return $wizard->toRichTextObject($data->getValue());
    }
}