<?php


namespace PaLabs\DatagridBundle\Grid\Form;


class GridFormData
{
    public $dataTableSettings;
    public $dataSourceSettings;

    public function getDataTableSettings()
    {
        return $this->dataTableSettings;
    }

    public function setDataTableSettings($dataTableSettings)
    {
        $this->dataTableSettings = $dataTableSettings;
        return $this;
    }

    public function getDataSourceSettings()
    {
        return $this->dataSourceSettings;
    }

    public function setDataSourceSettings($dataSourceSettings)
    {
        $this->dataSourceSettings = $dataSourceSettings;
        return $this;
    }


}