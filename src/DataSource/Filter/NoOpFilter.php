<?php


namespace PaLabs\DatagridBundle\DataSource\Filter;


class NoOpFilter implements FilterFormProvider
{

    public function formType(): string
    {
        return '';
    }

    public function formOptions(): array
    {
        return [];
    }
}