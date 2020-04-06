<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


class DataSourceResultContainer
{
    /** @var DataSourcePage[] */
    protected $pages;

    protected int $totalItemsCount;

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