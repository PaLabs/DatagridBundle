<?php


namespace PaLabs\DatagridBundle;


class GridUrlGenerator
{

    public static function generate(array $dataSourceParameters = [], array $gridSettings = [])
    {
        $parameters = [];
        if (!empty($dataSourceParameters)) {
            $parameters[GridForm::DATA_SOURCE_SETTINGS_FORM_NAME] = $dataSourceParameters;
        }
        if(!empty($gridSettings)) {
            $parameters[GridForm::GRID_SETTINGS_FORM_NAME] = $gridSettings;
        }

        if(empty($parameters)) {
            return [];
        }
        return [
            GridForm::FORM_NAME => $parameters
        ];
    }
}