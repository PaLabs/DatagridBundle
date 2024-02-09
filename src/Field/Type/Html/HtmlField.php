<?php


namespace PaLabs\DatagridBundle\Field\Type\Html;


use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;
use PaLabs\DatagridBundle\Grid\Export\XlsxExporter;
use PaLabs\DatagridBundle\Grid\GridOptions;
use PhpOffice\PhpSpreadsheet\Helper\Html;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

class HtmlField implements Field
{
    public static function field(string $value = '', array $options = []): HtmlFieldData
    {
        return new HtmlFieldData($value, $options);
    }

    public function render(FieldData $data, String $format): mixed
    {
        return match ($format) {
            GridOptions::RENDER_FORMAT_HTML => $this->renderHtml($data),
            XlsxExporter::FORMAT => $this->renderXlxs($data),
            default => $this->renderTxt($data),
        };
    }

    public function renderHtml(FieldData $data): string
    {
        if (!$data instanceof HtmlFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        return $data->getValue();
    }

    public function renderTxt(FieldData $data): string
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

    private function renderXlxs(FieldData $data): RichText
    {
        if (!$data instanceof HtmlFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }
        $wizard = new Html();
        return $wizard->toRichTextObject($data->getValue());
    }
}