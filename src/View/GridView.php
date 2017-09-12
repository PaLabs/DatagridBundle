<?php


namespace PaLabs\DatagridBundle\View;


use PaLabs\DatagridBundle\DataSource\Result\DataSourceResult;
use PaLabs\DatagridBundle\GridContext;
use Symfony\Component\Form\FormView;

class GridView
{

    protected $form;
    protected $header;
    protected $rows;
    protected $dataSourceResult;
    protected $context;

    public function __construct(
        $header,
        $rows,
        FormView $form,
        DataSourceResult $dataSourceResult,
        GridContext $context
    )
    {
        $this->header = $header;
        $this->rows = $rows;
        $this->form = $form;
        $this->dataSourceResult = $dataSourceResult;
        $this->context = $context;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function getForm(): FormView
    {
        return $this->form;
    }


    public function getDataSourceResult(): DataSourceResult
    {
        return $this->dataSourceResult;
    }

    public function getContext(): GridContext
    {
        return $this->context;
    }



}