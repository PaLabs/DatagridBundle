<?php


namespace PaLabs\DatagridBundle\DataTable;


class DataTableConfig
{
    protected $form;
    protected $formOptions;
    protected $formDefaults;

    public function __construct(
        $settingsForm,
        $settingsFormOptions,
        $defaultSettings)
    {
        $this->form = $settingsForm;
        $this->formOptions = $settingsFormOptions;
        $this->formDefaults = $defaultSettings;
    }

    public function getForm()
    {
        return $this->form;
    }

     public function getFormOptions()
    {
        return $this->formOptions;
    }

    public function getFormDefaults()
    {
        return $this->formDefaults;
    }


}