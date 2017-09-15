<?php


namespace PaLabs\DatagridBundle\Grid\View;


use PaLabs\DatagridBundle\DataSource\Result\DataSourceResultContainer;
use PaLabs\DatagridBundle\Grid\GridContext;
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
        DataSourceResultContainer $dataSourceResult,
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

    public function getContext(): GridContext
    {
        return $this->context;
    }

    public function getDataSourceResult(): DataSourceResultContainer
    {
        return $this->dataSourceResult;
    }



}