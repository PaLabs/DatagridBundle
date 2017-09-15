<?php

namespace PaLabs\DatagridBundle\DataSource;


use PaLabs\DatagridBundle\DataSource\Result\DataSourceResultContainer;
use PaLabs\DatagridBundle\Grid\GridContext;
use PaLabs\DatagridBundle\Grid\GridParameters;

interface ConfigurableDataSource
{
    public function configure(GridParameters $parameters): DataSourceConfiguration;

    public function rows(DataSourceConfiguration $configuration, GridContext $context): DataSourceResultContainer;
}