<?php


namespace PaLabs\DatagridBundle\DataSource;


use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\QueryBuilderFilterApplier;
use PaLabs\DatagridBundle\DataSource\Doctrine\Order\QueryBuilderSortApplier;

class DataSourceConfiguration
{
    protected $form;
    protected $formOptions;
    protected $formDefaults;

    protected $filters;
    protected $sorting;

    public function __construct(
        $settingsForm,
        $settingsFormOptions,
        $defaultSettings,
        $filters,
        $sorting)
    {
        $this->form = $settingsForm;
        $this->formOptions = $settingsFormOptions;
        $this->formDefaults = $defaultSettings;

        $this->filters = $filters;
        $this->sorting = $sorting;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function getFormOptions()
    {
        return $this->formOptions;
    }

    public function getFormDefaults()
    {
        return $this->formDefaults;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getSorting()
    {
        return $this->sorting;
    }


}