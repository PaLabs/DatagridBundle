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

abstract class AbstractConfigurableDataTable implements ConfigurableDataTable
{
    protected $columns;
    protected $columnMakersCaller;
    protected $displayColumnsBuilder;

    public function __construct()
    {
        $columnsBuilder = new ColumnsBuilder();
        $this->configureColumns($columnsBuilder);
        $this->columns = $columnsBuilder->build();

        $this->columnMakersCaller = new ColumnMakerCaller($this->columns);
        $this->displayColumnsBuilder = new DisplayColumnsBuilder($this->columns);
    }

    protected abstract function configureColumns(ColumnsBuilder $builder);

    public function configure(GridParameters $parameters): DataTableConfig
    {
        $settingsForm = $this->getSettingsForm($parameters);
        $settingsFormOptions = $this->getSettingsFormOptions($parameters);
        $defaultSettings = $this->defaultSettings($parameters);

        $config = new DataTableConfig($settingsForm, $settingsFormOptions, $defaultSettings);
        return $config;
    }

    public function rows(DataSourceResultContainer $container, DataTableConfig $config, GridContext $context) : DataTableResultContainer
    {
        $displayFields = $this->displayColumnsBuilder->build($context);

        $header = $this->buildHeader($context, $displayFields);
        $rows = $this->buildRows($container, $context, $displayFields);

        return new DataTableResultContainer($header, $rows);
    }

    private function buildRows(DataSourceResultContainer $container, GridContext $context, array $displayFields)
    {
        $loopIndex = 0;

        foreach ($container->getPages() as $page) {
            foreach ($page->getRows() as $rowData) {
                yield $this->buildRow($rowData, $loopIndex, $page, $context, $displayFields);
                $loopIndex++;
            }
        }

    }

    private function buildRow($rowData, int $loopIndex, DataSourcePage $page, GridContext $context, array $displayFields)
    {
        return array_map(function(string $fieldName) use($rowData, $loopIndex, $page, $context) {
            /** @var \PaLabs\DatagridBundle\DataTable\Column\Column $column * */
            $column = $this->columns[$fieldName];
            $columnMaker = $column->columnMaker;
            $columnMakerContext = new ColumnMakerContext($rowData, $loopIndex, $page, $context);

            return $this->columnMakersCaller->call($fieldName, $columnMaker, $columnMakerContext);
        }, $displayFields);
    }

    public function buildHeader(GridContext $context, array $displayFields)
    {
        $headerRow = array_map(function ($fieldName) use ($context) {
            /** @var \PaLabs\DatagridBundle\DataTable\Column\Column $field * */
            $field = $this->columns[$fieldName];

            if ($field->headerBuilder !== null) {
                $builder = $field->headerBuilder;
                return $builder($fieldName, $context);
            } else {
                return StringField::field($field->headerName);
            }
        }, $displayFields);

        return [$headerRow];
    }

    protected function defaultSettings(GridParameters $parameters)
    {
        return DataTableSettings::defaultSettings();
    }

    protected function getSettingsForm(GridParameters $parameters)
    {
        return SettingsForm::class;
    }

    protected function getSettingsFormOptions(GridParameters $parameters)
    {
        $displayFields = $this->displayFields($parameters);
        return [
            'fields' => $displayFields
        ];
    }

    protected function displayFields(GridParameters $parameters)
    {
        $fields = [];
        foreach ($this->columns as $name => $field) {
            /** @var \PaLabs\DatagridBundle\DataTable\Column\Column $field */
            if (!$field->required) {
                $fields[] = [
                    'name' => $name,
                    'label' => $field->columnListName
                ];
            }
        }
        return $fields;
    }


}