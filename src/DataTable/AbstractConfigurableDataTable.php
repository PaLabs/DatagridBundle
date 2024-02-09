<?php

namespace PaLabs\DatagridBundle\DataTable;


use PaLabs\DatagridBundle\DataSource\Result\DataSourcePage;
use PaLabs\DatagridBundle\DataSource\Result\DataSourceResultContainer;
use PaLabs\DatagridBundle\DataTable\Column\Column;
use PaLabs\DatagridBundle\DataTable\Column\ColumnsBuilder;
use PaLabs\DatagridBundle\DataTable\Form\SettingsForm;
use PaLabs\DatagridBundle\DataTable\Service\ColumnMakerCaller;
use PaLabs\DatagridBundle\DataTable\Service\DisplayColumnsBuilder;
use PaLabs\DatagridBundle\Grid\GridContext;
use PaLabs\DatagridBundle\Grid\GridParameters;

/**
 * Work schema:
 * 1) call configure() method to prepare configuration for given grid parameters
 * 2) call rows() with prepared configuration to produce rows
 */
abstract class AbstractConfigurableDataTable implements ConfigurableDataTable
{

    public function __construct()
    {
    }

    protected abstract function configureColumns(ColumnsBuilder $builder, GridParameters $parameters);

    public function configure(GridParameters $parameters): DataTableConfig
    {
        $columnsBuilder = new ColumnsBuilder();
        $this->configureColumns($columnsBuilder, $parameters);
        $columns = $columnsBuilder->build();

        $settingsForm = $this->getSettingsForm($parameters);
        $settingsFormOptions = $this->getSettingsFormOptions($columns, $parameters);
        $defaultSettings = $this->defaultSettings($parameters);

        return new DataTableConfig($columns, $settingsForm, $settingsFormOptions, $defaultSettings);
    }

    public function rows(
        DataSourceResultContainer $container,
        DataTableConfig $config,
        GridContext $context): DataTableResultContainer
    {
        $columns = $config->getColumns();
        $displayColumnNames = (new DisplayColumnsBuilder())->build($columns, $context);

        $header = $this->buildHeader($context, $columns, $displayColumnNames);
        $rows = $this->buildRows($container, $context, $columns, $displayColumnNames);

        return new DataTableResultContainer($header, $rows);
    }

    private function buildRows(
        DataSourceResultContainer $container,
        GridContext $context,
        array $columns,
        array $displayColumnNames): iterable
    {
        $loopIndex = 0;
        $columnMakersCaller = new ColumnMakerCaller($columns);

        foreach ($container->getPages() as $page) {
            foreach ($page->getRows() as $rowData) {
                yield $this->buildRow($rowData, $loopIndex, $page, $context, $columnMakersCaller, $columns, $displayColumnNames);
                $loopIndex++;
            }
        }

    }

    private function buildRow(
        $rowData,
        int $loopIndex,
        DataSourcePage $page,
        GridContext $context,
        ColumnMakerCaller $columnMakersCaller,
        array $columns,
        array $displayColumnNames): array
    {
        return array_map(
            function (string $columnName) use ($columnMakersCaller, $columns, $rowData, $loopIndex, $page, $context) {
                /** @var Column $column * */
                $column = $columns[$columnName];
                $columnMakerContext = new ColumnMakerContext($rowData, $loopIndex, $page, $context);

                return $columnMakersCaller->call($column, $columnMakerContext);
            },
            $displayColumnNames
        );
    }

    public function buildHeader(GridContext $context, array $columns, array $displayColumnNames): array
    {
        $headerRow = array_map(function ($columnName) use ($columns, $context) {
            /** @var Column $field * */
            $field = $columns[$columnName];
            $builder = $field->getOptions()->getHeaderBuilder();
            return $builder($context, $columnName);
        }, $displayColumnNames);

        return [$headerRow];
    }

    protected function defaultSettings(GridParameters $parameters): DataTableSettings
    {
        return new DataTableSettings([]);
    }

    protected function getSettingsForm(GridParameters $parameters): string
    {
        return SettingsForm::class;
    }

    protected function getSettingsFormOptions(array $columns, GridParameters $parameters): array
    {
        return [
            'fields' => $this->displayFields($columns, $parameters)
        ];
    }

    protected function displayFields(array $columns, GridParameters $parameters): array
    {
        $columns = array_filter($columns, function (Column $column) {
            return !$column->getOptions()->isRequired();
        });

        return array_map(function (Column $column) {
            return [
                'name' => $column->getName(),
                'label' => $column->getOptions()->getLabel(),
                'group' => $column->getOptions()->getGroup()
            ];
        }, $columns);
    }


}