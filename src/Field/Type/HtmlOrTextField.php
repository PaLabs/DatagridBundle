<?php


namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Grid\GridContext;
use PaLabs\DatagridBundle\Grid\GridOptions;

abstract class HtmlOrTextField implements Field
{
    public function render(FieldData $data, String $format)
    {
        switch ($format) {
            case GridOptions::RENDER_FORMAT_HTML:
                return $this->renderHtml($data);
            default:
                return $this->renderTxt($data);
        }
    }

    protected abstract function renderHtml(FieldData $data);

    protected abstract function renderTxt(FieldData $data);
}