<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


class DataSourcePage
{
    protected $rows;
    protected $pageContext;

    public function __construct(iterable $rows, DataSourcePageContext $pageContext)
    {
        $this->rows = $rows;
        $this->pageContext = $pageContext;
    }

    public function getRows(): iterable
    {
        return $this->rows;
    }

    public function getPageContext(): DataSourcePageContext
    {
        return $this->pageContext;
    }


}