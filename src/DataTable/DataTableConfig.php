<?php


namespace PaLabs\DatagridBundle\DataTable;


class DataTableConfig
{
    protected array $columns;
    protected string $form;
    protected array $formOptions;
    protected DataTableSettings $formDefaults;

    public function __construct(
        array $columns,
        string $form,
        array $formOptions,
        DataTableSettings $formDefaults)
    {
        $this->columns = $columns;
        $this->form = $form;
        $this->formOptions = $formOptions;
        $this->formDefaults = $formDefaults;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getForm(): string
    {
        return $this->form;
    }

     public function getFormOptions(): array
    {
        return $this->formOptions;
    }

    public function getFormDefaults(): DataTableSettings
    {
        return $this->formDefaults;
    }


}