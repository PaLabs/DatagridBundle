<?php


namespace PaLabs\DatagridBundle\Grid\View;


use PaLabs\DatagridBundle\DataSource\Result\DataSourceResultContainer;
use PaLabs\DatagridBundle\Grid\GridContext;
use Symfony\Component\Form\FormView;

class GridView
{

    public function __construct(
        protected iterable $header,
        protected iterable $rows,
        protected FormView $form,
        protected DataSourceResultContainer $dataSourceResult,
        protected GridContext $context
    )
    {
    }

    public function getHeader(): iterable
    {
        return $this->header;
    }

    public function getRows(): iterable
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