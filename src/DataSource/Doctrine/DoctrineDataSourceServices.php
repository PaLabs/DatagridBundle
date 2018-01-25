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
    protected $filterRegistry;

    public function __construct(
        EntityManagerInterface $em,
        PaginatorInterface $paginator,
        FilterRegistry $filterRegistry
    )
    {
        $this->em = $em;
        $this->paginator = $paginator;
        $this->filterRegistry = $filterRegistry;
    }

    public function getEm(): EntityManagerInterface
    {
        return $this->em;
    }

    public function getPaginator(): PaginatorInterface
    {
        return $this->paginator;
    }

    public function getFilterRegistry(): FilterRegistry
    {
        return $this->filterRegistry;
    }


}