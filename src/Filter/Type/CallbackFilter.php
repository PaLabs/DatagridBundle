<?php

namespace PaLabs\DatagridBundle\Filter\Type;


use PaLabs\DatagridBundle\Filter\FilterInterface;
use Doctrine\ORM\QueryBuilder;

class CallbackFilter implements FilterInterface
{
    public function getDefaultFormType()
    {
        return null;
    }

    public function getDefaultFormOptions()
    {
        return [];
    }

    public function apply(QueryBuilder $qb, $name, $criteria, array $options = [])
    {
        $callback = $options['callback'];
        $callback($name, $criteria, $qb, $options);
    }

}