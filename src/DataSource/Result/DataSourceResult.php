<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


use PaLabs\DatagridBundle\DataSource\DataSourcePage;

class DataSourceResult
{
    /** @var DataSourcePage[] */
    protected $pages;

    protected $hasData;

    public function __construct($pages, bool $hasData)
    {
        $this->pages = $pages;
        $this->hasData = $hasData;
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function isHasData(): bool
    {
        return $this->hasData;
    }




}