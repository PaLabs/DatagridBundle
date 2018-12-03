<?php


namespace PaLabs\DatagridBundle\DataSource;


use PaLabs\DatagridBundle\DataSource\Filter\FilterBuilder;
use PaLabs\DatagridBundle\DataSource\Order\SortBuilder;
use PaLabs\DatagridBundle\Grid\GridParameters;

abstract class AbstractConfigurableDataSource implements ConfigurableDataSource
{

    protected function configureFilters(FilterBuilder $builder, GridParameters $parameters):void
    {

    }

    protected function configureSorting(SortBuilder $builder, GridParameters $parameters): void
    {

    }

    protected function settingsForm(GridParameters $parameters): string
    {
        return DataSourceSettingsForm::class;
    }

    protected function settingsFormOptions(GridParameters $parameters): array
    {
        return [];
    }

    protected function defaultSettings(GridParameters $parameters) : DataSourceSettings
    {
        return DataSourceSettings::defaultSettings();
    }

    public function configure(GridParameters $parameters): DataSourceConfiguration
    {
        $filterBuilder =$this->createFilterBuilder();
        $this->configureFilters($filterBuilder, $parameters);
        $filters = $filterBuilder->getFilters();

        $sortBuilder = $this->createSortBuilder();
        $this->configureSorting($sortBuilder, $parameters);
        $sorting = $sortBuilder->getSorting();

        $defaultOptions = [
            'filters' => $filters,
            'sorting' => $sorting
        ];
        $extendedOptions = $this->settingsFormOptions($parameters);
        $formOptions = array_merge($defaultOptions, $extendedOptions);
        $formDefaults = $this->defaultSettings($parameters);

        $form = $this->settingsForm($parameters);
        return new DataSourceConfiguration($form, $formOptions, $formDefaults, $filters, $sorting);
    }

    protected function createSortBuilder(): SortBuilder {
        return new SortBuilder();
    }

    protected function createFilterBuilder(): FilterBuilder {
        return new FilterBuilder();
    }
}