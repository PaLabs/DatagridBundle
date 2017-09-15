<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


use PaLabs\DatagridBundle\DataSource\Result\DataSourcePage;

class DataSourceResultContainer
{
    /** @var DataSourcePage[] */
    protected $pages;

    /** @var  int */
    protected $totalItemsCount;

    public function __construct($pages, int $totalItemsCount)
    {
        $this->pages = $pages;
        $this->totalItemsCount = $totalItemsCount;
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function getTotalItemsCount(): int
    {
        return $this->totalItemsCount;
    }




}