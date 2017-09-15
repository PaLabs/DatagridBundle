<?php

namespace PaLabs\DatagridBundle\Filter;


use Doctrine\ORM\QueryBuilder;

interface FilterInterface
{
    public function formType(): string;
    public function formOptions(): array;

    public function apply($filtrable, string $name, $criteria, array $options = []);
}