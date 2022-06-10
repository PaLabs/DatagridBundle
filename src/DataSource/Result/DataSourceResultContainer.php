<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


class DataSourceResultContainer
{
    /** @var DataSourcePage[] */
    protected array $pages;

    protected int $totalItemsCount;

    public function __construct($pages, int $totalItemsCount)
    {
        $this->pages = $pages;
        $this->totalItemsCount = $totalItemsCount;
    }

    public function getPages(): array
    {
        return $this->pages;
    }

    public function getTotalItemsCount(): int
    {
        return $this->totalItemsCount;
    }




}