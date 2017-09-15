<?php


namespace PaLabs\DatagridBundle\DataTable;


class DataTableResultContainer
{
    protected $header;
    protected $rows;

    public function __construct($header, $rows)
    {
        $this->header = $header;
        $this->rows = $rows;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getRows()
    {
        return $this->rows;
    }


}