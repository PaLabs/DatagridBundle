<?php

namespace PaLabs\DatagridBundle\DataSource\Filter;


interface FilterInterface
{
    public function formType(): string;
    public function formOptions(): array;

    public function apply($filtrable, string $name, $criteria, array $options = []);
}