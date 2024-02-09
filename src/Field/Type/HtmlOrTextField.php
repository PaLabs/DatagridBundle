<?php


namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Grid\GridOptions;

abstract class HtmlOrTextField implements Field
{
    public function render(FieldData $data, String $format): string
    {
        return match ($format) {
            GridOptions::RENDER_FORMAT_HTML => $this->renderHtml($data),
            default => $this->renderTxt($data),
        };
    }

    protected abstract function renderHtml(FieldData $data): string;

    protected abstract function renderTxt(FieldData $data): string;
}