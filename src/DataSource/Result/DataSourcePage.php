<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


class DataSourcePage
{
    protected $rows;
    protected $pageContext;

    public function __construct($rows, $pageContext)
    {
        $this->rows = $rows;
        $this->pageContext = $pageContext;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function getPageContext()
    {
        return $this->pageContext;
    }


}