<?php

namespace PaLabs\DatagridBundle\DataTable;


use PaLabs\DatagridBundle\DataSource\Result\DataSourceResultContainer;
use PaLabs\DatagridBundle\Grid\GridContext;
use PaLabs\DatagridBundle\Grid\GridParameters;

interface ConfigurableDataTable
{
    public function configure(GridParameters $parameters): DataTableConfig;

    public function rows(DataSourceResultContainer $container, DataTableConfig $config, GridContext $context) : DataTableResultContainer;
}