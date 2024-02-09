<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


class DataSourcePage
{

    public function __construct(
        protected iterable $rows,
        protected DataSourcePageContext $pageContext)
    {
    }

    public function getRows(): iterable
    {
        return $this->rows;
    }

    public function getPageContext(): DataSourcePageContext
    {
        return $this->pageContext;
    }


}