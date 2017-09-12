<?php

namespace PaLabs\DatagridBundle;


use PaLabs\DatagridBundle\DataSource\DataSourceSettings;

class GridContext
{
    const PAGING_TYPE_SPLIT_BY_PAGES = 'split_by_pages';
    const PAGING_TYPE_SINGLE_PAGE = 'single_page';

    const DISPLAY_FORMAT_HTML = 'html';
    const DISPLAY_FORMAT_XSLX = 'xlsx';
    const DISPLAY_FORMAT_CSV = 'csv';

    /** @var  GridSettings */
    public $gridSettings;

    /** @var  DataSourceSettings */

    public $dataSourceSettings;

    /** @var GridParameters */
    public $parameters;

    public $pagingType;
    public $displayFormat;

    public function __construct(
        GridFormData $formData,
        GridParameters $parameters)
    {
        $this->gridSettings = $formData->getGridSettings();
        $this->dataSourceSettings = $formData->getDataSourceSettings();
        $this->parameters = $parameters;
    }


}