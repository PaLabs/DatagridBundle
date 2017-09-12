<?php

namespace PaLabs\DatagridBundle;


use PaLabs\DatagridBundle\DataSource\DataSourcePage;
use PaLabs\DatagridBundle\Field\GridColumn;
use PaLabs\DatagridBundle\Field\GridColumnsBuilder;
use PaLabs\DatagridBundle\Field\Type\StringField;
use PaLabs\DatagridBundle\Form\GridSettingsForm;

abstract class AbstractConfigurableGrid implements ConfigurableGridInterface
{
    protected $columns;
    protected $columnMakersCaller;

    public function __construct()
    {
        $columnsBuilder = new GridColumnsBuilder();
        $this->configureColumns($columnsBuilder);
        $this->columns = $columnsBuilder->build();

        $this->columnMakersCaller = new GridColumnMakerCaller($this->columns);
    }

    protected abstract function configureColumns(GridColumnsBuilder $builder);

    public function configure(GridParameters $parameters): GridConfig
    {
        $settingsForm = $this->getSettingsForm($parameters);
        $settingsFormOptions = $this->getSettingsFormOptions($parameters);
        $defaultSettings = $this->defaultSettings($parameters);

        $config = new GridConfig($settingsForm, $settingsFormOptions, $defaultSettings);
        return $config;
    }

    public function buildView($pages, GridConfig $config, GridContext $context)
    {
        $displayFields = $this->buildDisplayFields($context);

        $header = $this->buildHeader($context, $displayFields);
        $rows = $this->buildRows($pages, $context, $displayFields);

        return [
            'header' => $header,
            'rows' => $rows
        ];
    }

    protected function buildDisplayFields(GridContext $context)
    {
        $selectedFields = $context->gridSettings->getSelectedFields();

        $displayFields = [];
        foreach ($this->columns as $fieldName => $field) {
            /** @var GridColumn $field */
            if ($field->required && $this->needDisplayField($field, $context)) {
                $displayFields[] = $fieldName;
            }
        }

        foreach ($selectedFields as $field) {
            /** @var string $field */
            if (!array_key_exists($field, $this->columns)) {
                throw new \LogicException(sprintf("Unknown column field: %s", $field));
            }

            /** @var GridColumn $fieldDesc */
            $fieldDesc = $this->columns[$field];

            if ($this->needDisplayField($fieldDesc, $context)) {
                $displayFields[] = $field;
            }
        }

        return $displayFields;
    }

    private function buildRows($pages, GridContext $context, array $displayFields)
    {
        $loopIndex = 0;

        /** @var DataSourcePage[] $pages */
        foreach ($pages as $page) {
            foreach ($page->rows as $rowData) {
                yield $this->buildRow($rowData, $loopIndex, $page, $context, $displayFields);
                $loopIndex++;
            }
        }

    }

    private function buildRow($rowData, int $loopIndex, DataSourcePage $page, GridContext $context, array $displayFields)
    {
        $row = [];
        foreach ($displayFields as $fieldName) {
            /** @var GridColumn $field * */
            $field = $this->columns[$fieldName];
            $columnMaker = $field->columnMaker;
            $columnMakerContext = new ColumnMakerContext($rowData, $loopIndex, $page, $context);

            $row[] = $this->columnMakersCaller->call($fieldName, $columnMaker, $columnMakerContext);
        }
        return $row;
    }

    public function buildHeader(GridContext $context, array $displayFields)
    {
        $headerRow = array_map(function ($fieldName) use ($context) {
            /** @var GridColumn $field * */
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

    private function needDisplayField(GridColumn $field, GridContext $context)
    {
        if ($field->needDisplayCallback === null) {
            return true;
        }
        $callback = $field->needDisplayCallback;
        return $callback($context) === true;
    }

    protected function defaultSettings(GridParameters $parameters)
    {
        return GridSettings::defaultSettings();
    }

    protected function getSettingsForm(GridParameters $parameters)
    {
        return GridSettingsForm::class;
    }

    protected function getSettingsFormOptions($parameters)
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
            /** @var GridColumn $field */
            if (!$field->required) {
                $fields[] = [
                    'name' => $name,
                    'label' => $field->columnListName
                ];
            }
        }
        return $fields;
    }

    protected function addColumns(GridColumnsBuilder $builder, array $callbacks, array $options)
    {
        foreach ($callbacks as $name => $callback) {
            if (!isset($options[$name])) {
                throw new \Exception(sprintf("Options is not set form column %s", $name));
            }
            $columnOptions = $options[$name];
            if (is_string($columnOptions)) {
                $columnOptions = ['label' => $columnOptions];
            }

            $builder->add($name, new GridColumn($callback, $columnOptions));
        }
    }

}