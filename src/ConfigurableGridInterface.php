<?php

namespace PaLabs\DatagridBundle;


use PaLabs\DatagridBundle\DataSource\DataSourcePage;

interface ConfigurableGridInterface
{
    public function configure(GridParameters $parameters): GridConfig;

    /**
     * @param DataSourcePage[]|iterable $pages
     * @param GridConfig $config
     * @param GridContext $context
     * @return mixed
     */
    public function buildView($pages, GridConfig $config, GridContext $context);
}