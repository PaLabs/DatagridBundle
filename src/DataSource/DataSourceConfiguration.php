<?php


namespace PaLabs\DatagridBundle\DataSource;


class DataSourceConfiguration
{
    protected string $form;
    protected array $formOptions;
    protected DataSourceSettings $formDefaults;

    protected array $filters;
    protected array $sorting;

    public function __construct(
        string $settingsForm,
        array $settingsFormOptions,
        DataSourceSettings $defaultSettings,
        array $filters,
        array $sorting)
    {
        $this->form = $settingsForm;
        $this->formOptions = $settingsFormOptions;
        $this->formDefaults = $defaultSettings;

        $this->filters = $filters;
        $this->sorting = $sorting;
    }

    public function getForm(): string
    {
        return $this->form;
    }

    public function getFormOptions(): array
    {
        return $this->formOptions;
    }

    public function getFormDefaults(): DataSourceSettings
    {
        return $this->formDefaults;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getSorting(): array
    {
        return $this->sorting;
    }


}