<?php


namespace PaLabs\DatagridBundle\DataTable;


use PaLabs\DatagridBundle\DataSource\Result\DataSourcePage;
use PaLabs\DatagridBundle\Grid\GridContext;

class ColumnMakerContext
{

    public function __construct(
        protected mixed $row,
        protected int $loopIndex,
        protected DataSourcePage $page,
        protected GridContext $gridContext)
    {
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

    public function getRow(): mixed
    {
        return $this->row;
    }



}