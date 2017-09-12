<?php


namespace PaLabs\DatagridBundle;


class GridFormData
{
    public $gridSettings;
    public $dataSourceSettings;

    public function getGridSettings()
    {
        return $this->gridSettings;
    }

    public function setGridSettings($gridSettings)
    {
        $this->gridSettings = $gridSettings;
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