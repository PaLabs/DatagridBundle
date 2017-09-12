<?php

namespace PaLabs\DatagridBundle\DataSource;


use PaLabs\DatagridBundle\DataSource\Result\DataSourceResult;
use PaLabs\DatagridBundle\GridContext;
use PaLabs\DatagridBundle\GridParameters;

interface ConfigurableDataSource
{
    public function configure(GridParameters $parameters): DataSourceConfiguration;

    /**
     * @param DataSourceConfiguration $configuration
     * @param GridContext $context
     * @return DataSourceResult
     */
    public function rows(DataSourceConfiguration $configuration, GridContext $context);
}