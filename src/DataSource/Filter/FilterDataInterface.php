<?php


namespace PaLabs\DatagridBundle\DataSource\Filter;


interface FilterDataInterface
{
    public function isEnabled(): bool;
    public function toUrlParams(): array;

}