<?php


namespace PaLabs\DatagridBundle\Grid;


use PaLabs\DatagridBundle\Grid\Form\GridForm;

class GridUrlParametersBuilder
{

    public static function build(array $dataSourceParameters = [], array $dateTableSettings = [])
    {
        $parameters = [];

        if (!empty($dataSourceParameters)) {
            $parameters[GridForm::DATA_SOURCE_SETTINGS_FORM_NAME] = $dataSourceParameters;
        }
        if(!empty($dateTableSettings)) {
            $parameters[GridForm::DATA_TABLE_SETTINGS_FORM_NAME] = $dateTableSettings;
        }

        if(empty($parameters)) {
            return [];
        }
        return [
            GridForm::FORM_NAME => $parameters
        ];
    }
}