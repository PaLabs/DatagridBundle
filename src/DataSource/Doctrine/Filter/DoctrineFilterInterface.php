<?php


namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter;


use Doctrine\ORM\QueryBuilder;

interface DoctrineFilterInterface
{
    public function apply(QueryBuilder $qb, string $name, $criteria, array $options = []);
}