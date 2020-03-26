<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Options;


interface FilterOptions
{
    public function formOptions(): array;
    public function filterOptions(): array;
}