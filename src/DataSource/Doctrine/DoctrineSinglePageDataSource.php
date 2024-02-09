<?php


namespace PaLabs\DatagridBundle\DataSource\Doctrine;


use Doctrine\ORM\QueryBuilder;
use PaLabs\DatagridBundle\DataSource\DataSourceConfiguration;
use PaLabs\DatagridBundle\DataSource\Result\DataSourcePage;
use PaLabs\DatagridBundle\DataSource\Result\DataSourcePageContext;
use PaLabs\DatagridBundle\DataSource\Result\DataSourceResultContainer;
use PaLabs\DatagridBundle\Grid\GridContext;
use PaLabs\DatagridBundle\Grid\GridParameters;

abstract class DoctrineSinglePageDataSource extends DoctrineDataSource
{

    public function rows(DataSourceConfiguration $configuration, GridContext $context): DataSourceResultContainer
    {
        $queryBuilder = $this->createQuery($context);
        $this->applyFilterSorting($queryBuilder, $configuration, $context);

        return $this->allPagesRows($queryBuilder, $configuration, $context);
    }

    protected function allPagesRows(
        QueryBuilder $queryBuilder,
        DataSourceConfiguration $configuration,
        GridContext $context): DataSourceResultContainer
    {
        $rows = $queryBuilder->getQuery()->getResult();
        $pageContext = new DataSourcePageContext();
        $this->buildPageContext($rows, $configuration, $context, $pageContext);
        $pageRowsIterator = $this->transformPage($rows, $configuration, $context, $pageContext);

        $page = new DataSourcePage($pageRowsIterator, $pageContext);
        return new DataSourceResultContainer([$page], count($rows));
    }

    protected function settingsFormOptions(GridParameters $parameters): array
    {
        return [
            'enablePerPageSelector' => false
        ];
    }


}