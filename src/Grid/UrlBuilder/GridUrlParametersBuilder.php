<?php


namespace PaLabs\DatagridBundle\Grid\UrlBuilder;


use PaLabs\DatagridBundle\Grid\Form\GridForm;

class GridUrlParametersBuilder
{
    protected ?GridDataSourceUrlParameters $dataSourceUrlParameters = null;
    protected ?GridDataTableUrlParameters $dataTableUrlParameters = null;

    public function setDataSourceParameters(GridDataSourceUrlParameters $dataSourceUrlParameters): self
    {
        $this->dataSourceUrlParameters = $dataSourceUrlParameters;
        return $this;
    }

    public function setDataTableParameters(GridDataTableUrlParameters $dataTableUrlParameters): self
    {
        $this->dataTableUrlParameters = $dataTableUrlParameters;
        return $this;
    }

    public function build(): array
    {
        $parameters = [];

        if ($this->dataSourceUrlParameters !== null) {
            $dsParameters = $this->dataSourceUrlParameters->build();
            if (!empty($dsParameters)) {
                $parameters[GridForm::DATA_SOURCE_SETTINGS_FORM_NAME] = $dsParameters;
            }
        }
        
        if ($this->dataTableUrlParameters !== null) {
            $dtParameters = $this->dataTableUrlParameters->build();
            if(!empty($dtParameters)) {
                $parameters[GridForm::DATA_TABLE_SETTINGS_FORM_NAME] = $dtParameters;
            }
        }

        if (empty($parameters)) {
            return [];
        }
        return [
            GridForm::FORM_NAME => $parameters
        ];
    }
}