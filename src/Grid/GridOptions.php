<?php


namespace PaLabs\DatagridBundle\Grid;


class GridOptions
{
    public const string PAGING_TYPE_SPLIT_BY_PAGES = 'split_by_pages';
    public const string PAGING_TYPE_SINGLE_PAGE = 'single_page';

    public const string RENDER_FORMAT_HTML = 'html';

    protected string $pagingType;
    protected string $renderFormat;

    public function __construct(string $pagingType, string $renderFormat)
    {
        $this->pagingType = $pagingType;
        $this->renderFormat = $renderFormat;
    }

    public function getPagingType(): string
    {
        return $this->pagingType;
    }

    public function getRenderFormat(): string
    {
        return $this->renderFormat;
    }


}