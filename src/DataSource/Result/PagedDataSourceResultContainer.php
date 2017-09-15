<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


class PagedDataSourceResultContainer extends DataSourceResultContainer
{
    protected $pager;

    public function __construct($pages, Pager $pager)
    {
        parent::__construct($pages, $pager->getTotalItemsCount());
        $this->pager = $pager;
    }

    public function getPager(): Pager
    {
        return $this->pager;
    }


}