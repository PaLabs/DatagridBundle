<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


class DataSourcePagerResult extends DataSourceResult
{
    protected $pager;

    public function __construct($pages, Pager $pager)
    {
        parent::__construct($pages, $pager->getTotalItemsCount() > 0);
        $this->pager = $pager;
    }

    public function getPager(): Pager
    {
        return $this->pager;
    }


}