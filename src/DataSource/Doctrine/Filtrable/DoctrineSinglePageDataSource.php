<?php


namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filtrable;


use PaLabs\DatagridBundle\DataSource\DataSourceConfiguration;
use PaLabs\DatagridBundle\DataSource\DataSourcePage;
use PaLabs\DatagridBundle\DataSource\Result\DataSourceResult;
use PaLabs\DatagridBundle\GridContext;
use Doctrine\ORM\QueryBuilder;

abstract class DoctrineSinglePageDataSource extends DoctrineDataSource
{

    public function rows(DataSourceConfiguration $configuration, GridContext $context)
    {
        $queryBuilder = $this->createQuery($context);
        $this->applyFilterSorting($queryBuilder, $configuration, $context);

        return $this->allPagesRows($queryBuilder, $configuration, $context);
    }

    protected function allPagesRows(QueryBuilder $queryBuilder, DataSourceConfiguration $configuration, GridContext $context)
    {
        $rows = $queryBuilder->getQuery()->getResult();
        $pageContext = $this->fetchDataAfterPagination($rows, $configuration, $context);
        $pageRowsIterator = $this->transformDataIterator($rows, $configuration, $context, $pageContext);

        $page = new DataSourcePage($pageRowsIterator, $pageContext);
        $result = new DataSourceResult([$page], count($rows) > 0);
        return $result;
    }

    protected function getSettingsFormOptions($filters, $sorting)
    {
        return array_merge(parent::getSettingsFormOptions($filters, $sorting), [
            'enablePerPageSelector' => false
        ]);

    }


}