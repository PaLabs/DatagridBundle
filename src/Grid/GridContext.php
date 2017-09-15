<?php

namespace PaLabs\DatagridBundle\Grid;


use PaLabs\DatagridBundle\DataSource\DataSourceSettings;
use PaLabs\DatagridBundle\DataTable\DataTableSettings;
use PaLabs\DatagridBundle\Grid\Form\GridFormData;

class GridContext
{
    protected $dataTableSettings;
    protected $dataSourceSettings;
    protected $parameters;
    protected $options;

    public function __construct(
        GridFormData $formData,
        GridParameters $parameters,
        GridOptions $options)
    {
        $this->dataTableSettings = $formData->getDataTableSettings();
        $this->dataSourceSettings = $formData->getDataSourceSettings();
        $this->parameters = $parameters;
        $this->options = $options;
    }

    public function getDataTableSettings(): DataTableSettings
    {
        return $this->dataTableSettings;
    }

    public function getDataSourceSettings(): DataSourceSettings
    {
        return $this->dataSourceSettings;
    }

    public function getParameters(): GridParameters
    {
        return $this->parameters;
    }

    public function getOptions(): GridOptions
    {
        return $this->options;
    }



}