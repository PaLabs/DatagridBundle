<?php


namespace PaLabs\DatagridBundle\DataSource;


use PaLabs\DatagridBundle\DataSource\DataSourceSettings;
use PaLabs\DatagridBundle\DataSource\DataSourceSettingsForm;
use PaLabs\DatagridBundle\DataSource\Order\SortBuilder;
use PaLabs\DatagridBundle\Filter\FilterBuilder;
use PaLabs\DatagridBundle\Filter\Registry\FilterRegistry;
use PaLabs\DatagridBundle\Grid\GridParameters;

abstract class AbstractConfigurableDataSource implements ConfigurableDataSource
{

    protected $filterRegistry;

    public function __construct(FilterRegistry $filterRegistry)
    {
        $this->filterRegistry = $filterRegistry;
    }

    protected function configureFilters(FilterBuilder $builder, GridParameters $parameters)
    {

    }

    protected function configureSorting(SortBuilder $builder, GridParameters $parameters)
    {

    }

    protected function getSettingsForm(GridParameters $parameters): string
    {
        return DataSourceSettingsForm::class;
    }

    protected function getSettingsFormOptions(GridParameters $parameters): array
    {
        return [];
    }

    protected function getDefaultSettings(GridParameters $parameters) : DataSourceSettings
    {
        return DataSourceSettings::defaultSettings();
    }

    public function configure(GridParameters $parameters): DataSourceConfiguration
    {
        $filterBuilder = new FilterBuilder($this->filterRegistry);
        $this->configureFilters($filterBuilder, $parameters);
        $filters = $filterBuilder->getFilters();

        $sortBuilder = new SortBuilder();
        $this->configureSorting($sortBuilder, $parameters);
        $sorting = $sortBuilder->getSorting();

        $defaultOptions = [
            'filters' => $filters,
            'sorting' => $sorting
        ];
        $extendedOptions = $this->getSettingsFormOptions($parameters);
        $formOptions = array_merge($defaultOptions, $extendedOptions);
        $formDefaults = $this->getDefaultSettings($parameters);

        $form = $this->getSettingsForm($parameters);
        return new DataSourceConfiguration($form, $formOptions, $formDefaults, $filters, $sorting);
    }
}