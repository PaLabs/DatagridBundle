<?php


namespace PaLabs\DatagridBundle\DataTable;


use PaLabs\DatagridBundle\DataSource\Result\DataSourcePage;
use PaLabs\DatagridBundle\Grid\GridContext;

class ColumnMakerContext
{
    protected $gridContext;
    protected $page;
    protected $loopIndex;
    protected $row;

    public function __construct(
        $row,
        int $loopIndex,
        DataSourcePage $page,
        GridContext $gridContext)
    {
        $this->row = $row;
        $this->loopIndex = $loopIndex;
        $this->gridContext = $gridContext;
        $this->page = $page;
    }

    public function getGridContext(): GridContext
    {
        return $this->gridContext;
    }

    public function getPage(): DataSourcePage
    {
        return $this->page;
    }

    public function getLoopIndex(): int
    {
        return $this->loopIndex;
    }

    public function getRow()
    {
        return $this->row;
    }



}