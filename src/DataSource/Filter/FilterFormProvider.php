<?php

namespace PaLabs\DatagridBundle\DataSource\Filter;


interface FilterFormProvider
{
    public function formType(): string;
    public function formOptions(): array;
}