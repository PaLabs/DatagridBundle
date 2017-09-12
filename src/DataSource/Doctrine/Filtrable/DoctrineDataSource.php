<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filtrable;


use PaLabs\DatagridBundle\DataSource\ConfigurableDataSource;
use PaLabs\DatagridBundle\DataSource\DataSourceConfiguration;
use PaLabs\DatagridBundle\DataSource\DataSourcePage;
use PaLabs\DatagridBundle\DataSource\DataSourceSettings;
use PaLabs\DatagridBundle\DataSource\Doctrine\Filtrable\DataSourceSettingsForm;
use PaLabs\DatagridBundle\DataSource\Result\DataSourceResult;
use PaLabs\DatagridBundle\DataSource\Result\DataSourcePagerResult;
use PaLabs\DatagridBundle\DataSource\Result\Pager;
use PaLabs\DatagridBundle\Filter\FilterApplier;
use PaLabs\DatagridBundle\Filter\FilterBuilder;
use PaLabs\DatagridBundle\Sort\SortApplier;
use PaLabs\DatagridBundle\Sort\SortBuilder;
use PaLabs\DatagridBundle\GridContext;
use PaLabs\DatagridBundle\GridParameters;
use PaLabs\DatagridBundle\Util\DoctrineIterator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;

abstract class DoctrineDataSource implements ConfigurableDataSource
{
    protected $em;
    protected $paginator;
    protected $filterApplier;
    protected $sortApplier;

    public function __construct(
        EntityManagerInterface $em,
        PaginatorInterface $paginator,
        FilterApplier $filterApplier,
        SortApplier $sortApplier)
    {
        $this->em = $em;
        $this->paginator = $paginator;
        $this->filterApplier = $filterApplier;
        $this->sortApplier = $sortApplier;
    }

    protected abstract function configureFilters(FilterBuilder $builder, GridParameters $parameters);

    protected abstract function configureSorting(SortBuilder $builder, GridParameters $parameters);

    protected abstract function createQuery(GridContext $context);


    public function rows(DataSourceConfiguration $configuration, GridContext $context)
    {
        $queryBuilder = $this->createQuery($context);
        $this->applyFilterSorting($queryBuilder, $configuration, $context);

        switch ($context->pagingType) {
            case GridContext::PAGING_TYPE_SPLIT_BY_PAGES:
                return $this->onePageRows($queryBuilder, $configuration, $context);
            case GridContext::PAGING_TYPE_SINGLE_PAGE:
                return $this->allPagesRows($queryBuilder, $configuration, $context);
            default:
                throw new \Exception(sprintf("Unsupported context type: %s", $context->pagingType));
        }

    }

    protected function applyFilterSorting(QueryBuilder $queryBuilder, DataSourceConfiguration $configuration, GridContext $context)
    {
        $this->filterApplier->apply($queryBuilder, $configuration->getFilters(), $context->dataSourceSettings->getFilters());
        $this->sortApplier->apply($queryBuilder, $configuration->getSorting(), $context->dataSourceSettings->getOrder());
    }

    protected function onePageRows(QueryBuilder $queryBuilder, DataSourceConfiguration $configuration, GridContext $context)
    {
        /** @var SlidingPagination $pagination */
        $pagination = $this->paginator->paginate($queryBuilder, $context->dataSourceSettings->getPage(),
            $context->dataSourceSettings->getPerPage());

        $pageContext = $this->fetchDataAfterPagination($pagination->getItems(), $configuration, $context);
        $pageRowsIterator = $this->transformDataIterator($pagination->getItems(), $configuration, $context, $pageContext);
        $page = new DataSourcePage($pageRowsIterator, $pageContext);
        $result = new DataSourcePagerResult([$page], Pager::fromKpnPagination($pagination));
        return $result;
    }

    protected function allPagesRows(QueryBuilder $queryBuilder, DataSourceConfiguration $configuration, GridContext $context)
    {
        $itemsCount = DoctrineIterator::count($queryBuilder);
        $pageIterator = $this->allPagesRowsIterator($queryBuilder, $itemsCount, $configuration, $context);
        $result = new DataSourceResult($pageIterator, $itemsCount > 0);
        return $result;
    }

    protected function allPagesRowsIterator(QueryBuilder $queryBuilder, $itemsCount, DataSourceConfiguration $configuration, GridContext $context)
    {
        $doctrineIterator = DoctrineIterator::iterator($queryBuilder, $itemsCount);
        foreach ($doctrineIterator as $rowData) {
            $pageContext = $this->fetchDataAfterPagination($rowData, $configuration, $context);
            $pageRowsIterator = $this->transformDataIterator($rowData, $configuration, $context, $pageContext);
            $page = new DataSourcePage($pageRowsIterator, $pageContext);

            yield $page;
            $this->em->clear();
        }
    }

    protected function transformDataIterator($rows, DataSourceConfiguration $configuration, GridContext $context, $pageContext)
    {
        foreach ($rows as $row) {
            yield $row;
        }
    }


    protected function fetchDataAfterPagination($rows, DataSourceConfiguration $configuration, GridContext $context)
    {

    }


    protected function getSettingsForm(GridParameters $parameters)
    {
        return DataSourceSettingsForm::class;
    }

    protected function getSettingsFormOptions($filters, $sorting)
    {
        return [
            'filters' => $filters,
            'sorting' => $sorting
        ];
    }

    protected function getDefaultSettings(GridParameters $parameters)
    {
        return DataSourceSettings::defaultSettings();
    }

    public function configure(GridParameters $parameters): DataSourceConfiguration
    {
        $filterBuilder = new FilterBuilder();
        $this->configureFilters($filterBuilder, $parameters);
        $filters = $filterBuilder->getFilters();

        $sortBuilder = new SortBuilder();
        $this->configureSorting($sortBuilder, $parameters);
        $sorting = $sortBuilder->getSorting();

        $form = $this->getSettingsForm($parameters);
        $formOptions = $this->getSettingsFormOptions($filters, $sorting);
        $formDefaults = $this->getDefaultSettings($parameters);

        return new DataSourceConfiguration($form, $formOptions, $formDefaults, $filters, $sorting);
    }


}
