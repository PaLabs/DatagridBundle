<?php


namespace PaLabs\DatagridBundle\DataSource;


use PaLabs\DatagridBundle\DataSource\Order\SortBuilder;
use PaLabs\DatagridBundle\DataSource\Filter\FilterBuilder;
use PaLabs\DatagridBundle\DataSource\Filter\Registry\FilterRegistry;
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
        $extendedOptions = $this->getSettingsFormOptions($parameters);
        $formOptions = array_merge($defaultOptions, $extendedOptions);
        $formDefaults = $this->getDefaultSettings($parameters);

        $form = $this->getSettingsForm($parameters);
        return new DataSourceConfiguration($form, $formOptions, $formDefaults, $filters, $sorting);
    }

    protected function createSortBuilder(): SortBuilder {
        return new SortBuilder();
    }

    protected function createFilterBuilder(): FilterBuilder {
        return new FilterBuilder($this->filterRegistry);
    }
}