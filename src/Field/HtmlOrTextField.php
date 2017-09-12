<?php


namespace PaLabs\DatagridBundle\Field;


use PaLabs\DatagridBundle\GridContext;

abstract class HtmlOrTextField implements Field
{
    public function render(FieldData $data, String $displayFormat)
    {
        switch ($displayFormat) {
            case GridContext::DISPLAY_FORMAT_HTML:
                return $this->renderHtml($data);
            default:
                return $this->renderTxt($data);
        }
    }

    protected abstract function renderHtml(FieldData $data);

    protected abstract function renderTxt(FieldData $data);
}