<?php


namespace PaLabs\DatagridBundle\Grid\Form;


use PaLabs\DatagridBundle\DataSource\DataSourceSettings;
use PaLabs\DatagridBundle\DataTable\DataTableSettings;

class GridFormData
{
    public ?DataTableSettings $dataTableSettings = null;
    public ?DataSourceSettings $dataSourceSettings = null;

    public function getDataTableSettings(): ?DataTableSettings
    {
        return $this->dataTableSettings;
    }

    public function setDataTableSettings(DataTableSettings $dataTableSettings): self
    {
        $this->dataTableSettings = $dataTableSettings;
        return $this;
    }

    public function getDataSourceSettings(): ?DataSourceSettings
    {
        return $this->dataSourceSettings;
    }

    public function setDataSourceSettings(?DataSourceSettings $dataSourceSettings): self
    {
        $this->dataSourceSettings = $dataSourceSettings;
        return $this;
    }


}