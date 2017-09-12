<?php


namespace PaLabs\DatagridBundle;


use PaLabs\DatagridBundle\DataSource\DataSourcePage;

class ColumnMakerContext
{
    public $gridContext;
    public $page;
    public $loopIndex;
    public $row;

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

}