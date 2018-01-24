<?php


namespace PaLabs\DatagridBundle\DataTable\Column\Type;


use PaLabs\DatagridBundle\DataTable\Column\Column;
use PaLabs\DatagridBundle\DataTable\ColumnMakerContext;
use PaLabs\DatagridBundle\Field\Type\String\StringField;
use PaLabs\DatagridBundle\Grid\GridContext;
use PaLabs\DatagridBundle\Grid\GridOptions;

class NumberingColumn extends Column
{

    public function __construct(array $columnParameters = [])
    {
        $columnMaker = function (ColumnMakerContext $context) {
            $dsSettings = $context->getGridContext()->getDataSourceSettings();
            $recordNumber = (($dsSettings->getPage() - 1) * $dsSettings->getPerPage()) + ($context->getLoopIndex() + 1);
            return StringField::field($recordNumber);
        };
        $parameters = array_merge($columnParameters, $this->defaultParameters());


        parent::__construct($columnMaker, $parameters);
    }

    private function defaultParameters()
    {
        return [
            'label' => '',
            'required' => true,
            'need_display' => function (GridContext $context) {
                return $context->getOptions()->getRenderFormat() == GridOptions::RENDER_FORMAT_HTML;
            },
            'header_builder' => function () {
                return StringField::field('#', []);
            }
        ];
    }
}