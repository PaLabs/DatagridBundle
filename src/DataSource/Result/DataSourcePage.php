<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


class DataSourcePage
{
    public $rows;
    public $pageContext;


    public function __construct($rows, $pageContext)
    {
        $this->rows = $rows;
        $this->pageContext = $pageContext;
    }
}