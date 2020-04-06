<?php

namespace PaLabs\DatagridBundle\DataTable;


class DataTableSettings
{
    /** @var string[] */
    protected array $selectedFields = [];

    public function __construct(array $selectedFields = [])
    {
        $this->selectedFields = $selectedFields;
    }

    public function getSelectedFields(): array
    {
        return $this->selectedFields;
    }

    public function setSelectedFields(array $selectedFields): self
    {
        $this->selectedFields = $selectedFields;
        return $this;
    }



}