<?php


namespace PaLabs\DatagridBundle\DataSource\Doctrine;


use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\QueryBuilderFilterApplier;
use PaLabs\DatagridBundle\DataSource\Doctrine\Order\QueryBuilderSortApplier;
use PaLabs\DatagridBundle\DataSource\Filter\Registry\FilterRegistry;

class DoctrineDataSourceServices
{
    protected $em;
    protected $paginator;
    protected $filterApplier;
    protected $sortApplier;

    public function __construct(
        EntityManagerInterface $em,
        PaginatorInterface $paginator,
        QueryBuilderFilterApplier $filterApplier,
        QueryBuilderSortApplier $sortApplier
    )
    {
        $this->em = $em;
        $this->paginator = $paginator;
        $this->filterApplier = $filterApplier;
        $this->sortApplier = $sortApplier;
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