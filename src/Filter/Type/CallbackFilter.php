<?php

namespace PaLabs\DatagridBundle\Filter\Type;


use PaLabs\DatagridBundle\Filter\FilterInterface;
use Doctrine\ORM\QueryBuilder;

class CallbackFilter implements FilterInterface
{
    public function formType(): string
    {
        return '';
    }

    public function formOptions(): array
    {
        return [];
    }

    public function apply($qb, string $name, $criteria, array $options = [])
    {
        $callback = $options['callback'];
        return $callback($name, $criteria, $qb, $options);
    }

}