<?php


namespace PaLabs\DatagridBundle\DataTable\Service;


use PaLabs\DatagridBundle\DataTable\Column\Column;
use PaLabs\DatagridBundle\Grid\GridContext;

class DisplayColumnsBuilder
{

    public function build(array $columns, GridContext $context)
    {
        $selectedColumnNames = $context->getDataTableSettings()->getSelectedFields();

        return array_merge(
            $this->requiredColumnNames($columns),
            $this->selectedColumnNames($columns, $selectedColumnNames, $context)
        );
    }

    private function requiredColumnNames(array $columns): array
    {
        $requiredColumns = array_filter($columns, function(Column $column){
            return $column->getOptions()->isRequired();
        });

        return array_map(function(Column $column){
            return $column->getName();
        }, $requiredColumns);
    }

    private function selectedColumnNames(array $columns, array $selectedColumnNames, GridContext $context): array
    {
        $selectedColumns = array_map(function(string $columnName) use ($columns) {
            if (!array_key_exists($columnName, $columns)) {
                throw new \LogicException(sprintf("Unknown column field: %s", $columnName));
            }
            return $columns[$columnName];
        }, $selectedColumnNames);

        $selectedColumns = array_filter($selectedColumns, function(Column $column) use ($context) {
            $callback = $column->getOptions()->getNeedDisplayChecker();
            return $callback($context) === true;
        });

        return array_map(function(Column $column){
            return $column->getName();
        }, $selectedColumns);
    }
}