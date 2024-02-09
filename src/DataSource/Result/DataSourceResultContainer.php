<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


class DataSourceResultContainer
{

    public function __construct(
        protected iterable $pages,
        protected int $totalItemsCount)
    {
    }

    /**
     * @return iterable<DataSourcePage>
     */
    public function getPages(): iterable
    {
        return $this->pages;
    }

    public function getTotalItemsCount(): int
    {
        return $this->totalItemsCount;
    }




}