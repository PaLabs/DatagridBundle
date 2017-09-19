<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filtrable;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use PaLabs\DatagridBundle\DataSource\AbstractConfigurableDataSource;
use PaLabs\DatagridBundle\DataSource\ConfigurableDataSource;
use PaLabs\DatagridBundle\DataSource\DataSourceConfiguration;
use PaLabs\DatagridBundle\DataSource\Doctrine\Order\DoctrineSortBuilder;
use PaLabs\DatagridBundle\DataSource\Result\DataSourcePage;
use PaLabs\DatagridBundle\DataSource\DataSourceSettings;
use PaLabs\DatagridBundle\DataSource\Doctrine\Order\QueryBuilderSortApplier;
use PaLabs\DatagridBundle\DataSource\Order\SortBuilder;
use PaLabs\DatagridBundle\DataSource\Result\DataSourceResultContainer;
use PaLabs\DatagridBundle\DataSource\Result\PagedDataSourceResultContainer;
use PaLabs\DatagridBundle\DataSource\Result\Pager;
use PaLabs\DatagridBundle\DataTable\AbstractConfigurableDataTable;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\QueryBuilderFilterApplier;
use PaLabs\DatagridBundle\DataSource\Filter\FilterBuilder;
use PaLabs\DatagridBundle\DataSource\Filter\Registry\FilterRegistry;
use PaLabs\DatagridBundle\Grid\GridContext;
use PaLabs\DatagridBundle\Grid\GridOptions;
use PaLabs\DatagridBundle\Grid\GridParameters;
use PaLabs\DatagridBundle\Util\DoctrineIterator;

abstract class DoctrineDataSource extends AbstractConfigurableDataSource
{
    protected $em;
    protected $paginator;
    protected $filterApplier;
    protected $sortApplier;

    public function __construct(
        EntityManagerInterface $em,
        PaginatorInterface $paginator,
        QueryBuilderFilterApplier $filterApplier,
        QueryBuilderSortApplier $sortApplier,
        FilterRegistry $filterRegistry)
    {
        parent::__construct($filterRegistry);
        $this->em = $em;
        $this->paginator = $paginator;
        $this->filterApplier = $filterApplier;
        $this->sortApplier = $sortApplier;
        $this->filterRegistry = $filterRegistry;
    }

    protected abstract function createQuery(GridContext $context);


    public function rows(DataSourceConfiguration $configuration, GridContext $context) : DataSourceResultContainer
    {
        $queryBuilder = $this->createQuery($context);
        $this->applyFilterSorting($queryBuilder, $configuration, $context);

        switch ($context->getOptions()->getPagingType()) {
            case GridOptions::PAGING_TYPE_SPLIT_BY_PAGES:
                return $this->onePageRows($queryBuilder, $configuration, $context);
            case GridOptions::PAGING_TYPE_SINGLE_PAGE:
                return $this->allPagesRows($queryBuilder, $configuration, $context);
            default:
                throw new \Exception(sprintf("Unsupported context type: %s",$context->getOptions()->getPagingType()));
        }

    }

    protected function applyFilterSorting(QueryBuilder $queryBuilder, DataSourceConfiguration $configuration, GridContext $context)
    {
        $this->filterApplier->apply($queryBuilder, $configuration->getFilters(), $context->getDataSourceSettings()->getFilters());
        $this->sortApplier->apply($queryBuilder, $configuration->getSorting(), $context->getDataSourceSettings()->getOrder());
    }

    protected function onePageRows(QueryBuilder $queryBuilder, DataSourceConfiguration $configuration, GridContext $context)
    {
        /** @var SlidingPagination $pagination */
        $pagination = $this->paginator->paginate($queryBuilder, $context->getDataSourceSettings()->getPage(),
            $context->getDataSourceSettings()->getPerPage());
        $rows = $pagination->getItems();

        $pageContext = $this->buildPageContext($rows, $configuration, $context);
        $pageRowsIterator = $this->transformPage($rows, $configuration, $context, $pageContext);
        $page = new DataSourcePage($pageRowsIterator, $pageContext);
        $result = new PagedDataSourceResultContainer([$page], Pager::fromKpnPagination($pagination));
        return $result;
    }

    protected function allPagesRows(QueryBuilder $queryBuilder, DataSourceConfiguration $configuration, GridContext $context)
    {
        $itemsCount = DoctrineIterator::count($queryBuilder);
        $pageIterator = $this->allPagesRowsIterator($queryBuilder, $itemsCount, $configuration, $context);
        $result = new DataSourceResultContainer($pageIterator, $itemsCount);
        return $result;
    }

    protected function allPagesRowsIterator(QueryBuilder $queryBuilder, $itemsCount, DataSourceConfiguration $configuration, GridContext $context)
    {
        $doctrineIterator = DoctrineIterator::iterator($queryBuilder, $itemsCount);
        foreach ($doctrineIterator as $rowData) {
            $pageContext = $this->buildPageContext($rowData, $configuration, $context);
            $pageRowsIterator = $this->transformPage($rowData, $configuration, $context, $pageContext);
            $page = new DataSourcePage($pageRowsIterator, $pageContext);

            yield $page;
            $this->em->clear();
        }
    }

    protected function transformPage(array $rows, DataSourceConfiguration $configuration, GridContext $context, $pageContext)
    {
        return $rows;
    }


    protected function buildPageContext(array $rows, DataSourceConfiguration $configuration, GridContext $context)
    {
        return [];
    }

    protected function createSortBuilder(): SortBuilder {
        return new DoctrineSortBuilder();
    }

}
