<?php

namespace PaLabs\DatagridBundle\DataTable;


use PaLabs\DatagridBundle\DataTable\Column\ColumnsBuilder;
use PaLabs\DatagridBundle\DataSource\Result\DataSourcePage;
use PaLabs\DatagridBundle\DataSource\Result\DataSourceResultContainer;
use PaLabs\DatagridBundle\DataTable\Form\SettingsForm;
use PaLabs\DatagridBundle\DataTable\Service\ColumnMakerCaller;
use PaLabs\DatagridBundle\DataTable\Service\DisplayColumnsBuilder;
use PaLabs\DatagridBundle\Field\Type\String\StringField;
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
        $displayFields = (new DisplayColumnsBuilder())->build($columns, $context);

        $header = $this->buildHeader($context, $columns, $displayFields);
        $rows = $this->buildRows($container, $context, $columns, $displayFields);

        return new DataTableResultContainer($header, $rows);
    }

    private function buildRows(
        DataSourceResultContainer $container,
        GridContext $context,
        array $columns,
        array $displayFields)
    {
        $loopIndex = 0;
        $columnMakersCaller = new ColumnMakerCaller($columns);

        foreach ($container->getPages() as $page) {
            foreach ($page->getRows() as $rowData) {
                yield $this->buildRow($rowData, $loopIndex, $page, $context, $columnMakersCaller, $columns, $displayFields);
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
        array $displayFields)
    {
        return array_map(function (string $fieldName) use ($columnMakersCaller, $columns, $rowData, $loopIndex, $page, $context) {
            /** @var \PaLabs\DatagridBundle\DataTable\Column\Column $column * */
            $column = $columns[$fieldName];
            $columnMaker = $column->getColumnMaker();
            $columnMakerContext = new ColumnMakerContext($rowData, $loopIndex, $page, $context);

            return $columnMakersCaller->call($fieldName, $columnMaker, $columnMakerContext);
        }, $displayFields);
    }

    public function buildHeader(GridContext $context, array $columns, array $displayFields)
    {
        $headerRow = array_map(function ($fieldName) use ($columns, $context) {
            /** @var \PaLabs\DatagridBundle\DataTable\Column\Column $field * */
            $field = $columns[$fieldName];

            if ($field->getHeaderBuilder() !== null) {
                $builder = $field->getHeaderBuilder();
                return $builder($context, $fieldName);
            } else {
                return StringField::field($field->getHeaderLabel());
            }
        }, $displayFields);

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

    protected function displayFields(array $columns, GridParameters $parameters)
    {
        $fields = [];
        foreach ($columns as $name => $field) {
            /** @var \PaLabs\DatagridBundle\DataTable\Column\Column $field */
            if (!$field->isRequired()) {
                $fields[] = [
                    'name' => $name,
                    'label' => $field->getColumnListLabel()
                ];
            }
        }
        return $fields;
    }


}