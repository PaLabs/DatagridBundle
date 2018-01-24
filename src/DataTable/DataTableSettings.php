<?php

namespace PaLabs\DatagridBundle\DataTable;


class DataTableSettings
{
    /** @var string[] */
    protected $selectedFields = [];

    public function __construct(array $selectedFields)
    {
        $this->selectedFields = $selectedFields;
    }

    public function getSelectedFields(): array
    {
        return $this->selectedFields;
    }

}