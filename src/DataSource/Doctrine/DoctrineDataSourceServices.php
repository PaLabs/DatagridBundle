<?php


namespace PaLabs\DatagridBundle\DataSource\Doctrine;


use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\QueryBuilderFilterApplier;
use PaLabs\DatagridBundle\DataSource\Doctrine\Order\QueryBuilderSortApplier;

class DoctrineDataSourceServices
{

    public function __construct(
        protected EntityManagerInterface $em,
        protected PaginatorInterface $paginator,
        protected QueryBuilderFilterApplier $filterApplier,
        protected QueryBuilderSortApplier $sortApplier
    )
    {
    }

    public function getEm(): EntityManagerInterface
    {
        return $this->em;
    }

    public function getPaginator(): PaginatorInterface
    {
        return $this->paginator;
    }

    public function getFilterApplier(): QueryBuilderFilterApplier
    {
        return $this->filterApplier;
    }

    public function getSortApplier(): QueryBuilderSortApplier
    {
        return $this->sortApplier;
    }



}