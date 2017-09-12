<?php

namespace PaLabs\DatagridBundle\Filter;


use Doctrine\ORM\QueryBuilder;

interface FilterInterface
{
    public function getDefaultFormType();
    public function getDefaultFormOptions();

    public function apply(QueryBuilder $qb, $name, $criteria, array $options = []);
}