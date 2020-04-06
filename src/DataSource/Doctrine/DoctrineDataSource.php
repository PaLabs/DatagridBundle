<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;
use PaLabs\DatagridBundle\DataSource\AbstractConfigurableDataSource;
use PaLabs\DatagridBundle\DataSource\DataSourceConfiguration;
use PaLabs\DatagridBundle\DataSource\Doctrine\Order\DoctrineSortBuilder;
use PaLabs\DatagridBundle\DataSource\Order\SortBuilder;
use PaLabs\DatagridBundle\DataSource\Result\DataSourcePage;
use PaLabs\DatagridBundle\DataSource\Result\DataSourcePageContext;
use PaLabs\DatagridBundle\DataSource\Result\DataSourceResultContainer;
use PaLabs\DatagridBundle\DataSource\Result\PagedDataSourceResultContainer;
use PaLabs\DatagridBundle\DataSource\Result\Pager;
use PaLabs\DatagridBundle\Grid\GridContext;
use PaLabs\DatagridBundle\Grid\GridOptions;
use PaLabs\DatagridBundle\Util\DoctrineIterator;

abstract class DoctrineDataSource extends AbstractConfigurableDataSource
{
    protected EntityManagerInterface $em;
    protected PaginatorInterface $paginator;
    protected Filter\QueryBuilderFilterApplier $filterApplier;
    protected Order\QueryBuilderSortApplier $sortApplier;

    public function __construct(DoctrineDataSourceServices $services)
    {
        $this->em = $services->getEm();
        $this->paginator = $services->getPaginator();
        $this->filterApplier = $services->getFilterApplier();
        $this->sortApplier = $services->getSortApplier();
    }

    protected abstract function createQuery(GridContext $context): QueryBuilder;


    public function rows(DataSourceConfiguration $configuration, GridContext $context): DataSourceResultContainer
    {
        $queryBuilder = $this->createQuery($context);
        $this->applyFilterSorting($queryBuilder, $configuration, $context);

        switch ($context->getOptions()->getPagingType()) {
            case GridOptions::PAGING_TYPE_SPLIT_BY_PAGES:
                return $this->onePageRows($queryBuilder, $configuration, $context);
            case GridOptions::PAGING_TYPE_SINGLE_PAGE:
                return $this->allPagesRows($queryBuilder, $configuration, $context);
            default:
                throw new Exception(sprintf("Unsupported context type: %s", $context->getOptions()->getPagingType()));
        }

    }

    protected function applyFilterSorting(QueryBuilder $queryBuilder, DataSourceConfiguration $configuration,
                                          GridContext $context): void
    {
        $this->filterApplier->apply($queryBuilder, $configuration->getFilters(), $context->getDataSourceSettings()->getFilters());
        $this->sortApplier->apply($queryBuilder, $configuration->getSorting(), $context->getDataSourceSettings()->getOrder());
    }

    protected function onePageRows(QueryBuilder $queryBuilder, DataSourceConfiguration $configuration,
                                   GridContext $context): DataSourceResultContainer
    {
        /** @var SlidingPagination $pagination */
        $pagination = $this->paginator->paginate($queryBuilder, $context->getDataSourceSettings()->getPage(),
            $context->getDataSourceSettings()->getPerPage());
        $rows = $pagination->getItems();

        $pageContext = new DataSourcePageContext();
        $this->buildPageContext($rows, $configuration, $context, $pageContext);
        $pageRowsIterator = $this->transformPage($rows, $configuration, $context, $pageContext);

        $page = new DataSourcePage($pageRowsIterator, $pageContext);
        return new PagedDataSourceResultContainer([$page], Pager::fromKpnPagination($pagination));
    }

    protected function allPagesRows(QueryBuilder $queryBuilder, DataSourceConfiguration $configuration,
                                    GridContext $context): DataSourceResultContainer
    {
        $itemsCount = DoctrineIterator::count($queryBuilder);
        $pageIterator = $this->allPagesRowsIterator($queryBuilder, $itemsCount, $configuration, $context);
        return new DataSourceResultContainer($pageIterator, $itemsCount);
    }

    protected function allPagesRowsIterator(QueryBuilder $queryBuilder, $itemsCount,
                                            DataSourceConfiguration $configuration, GridContext $context): iterable
    {
        $doctrineIterator = DoctrineIterator::iterator($queryBuilder, $itemsCount);
        foreach ($doctrineIterator as $rowData) {
            $pageContext = new DataSourcePageContext();
            $this->buildPageContext($rowData, $configuration, $context, $pageContext);

            $pageRowsIterator = $this->transformPage($rowData, $configuration, $context, $pageContext);
            yield new DataSourcePage($pageRowsIterator, $pageContext);
            $this->em->clear();
        }
    }

    protected function transformPage(array $rows, DataSourceConfiguration $configuration,
                                     GridContext $context, DataSourcePageContext $pageContext): iterable
    {
        return $rows;
    }


    protected function buildPageContext(array $rows, DataSourceConfiguration $configuration,
                                        GridContext $context, DataSourcePageContext $pageContext): void
    {
    }

    protected function createSortBuilder(): SortBuilder
    {
        return new DoctrineSortBuilder();
    }

}
