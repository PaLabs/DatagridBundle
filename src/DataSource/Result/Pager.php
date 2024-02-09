<?php


namespace PaLabs\DatagridBundle\DataSource\Result;


use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use PaLabs\DatagridBundle\DataSource\DataSourceSettingsForm;
use PaLabs\DatagridBundle\Grid\Form\GridForm;

class Pager
{
    protected int $pageRange = 5;

    public function __construct(
        protected int $currentPageNumber,
        protected int $itemNumberPerPage,
        protected int $totalItemsCount)
    {
    }

    public static function fromKpnPagination(SlidingPagination $pagination): static
    {
        return new Pager(
            $pagination->getCurrentPageNumber(),
            $pagination->getItemNumberPerPage(),
            $pagination->getTotalItemCount()
        );
    }


    public function getPaginationData(): array
    {
        $pageCount = $this->getPageCount();
        $current = $this->currentPageNumber;

        if ($pageCount < $current) {
            $this->currentPageNumber = $current = $pageCount;
        }

        if ($this->pageRange > $pageCount) {
            $this->pageRange = $pageCount;
        }

        $delta = ceil($this->pageRange / 2);

        if ($current - $delta > $pageCount - $this->pageRange) {
            $pages = range($pageCount - $this->pageRange + 1, $pageCount);
        } else {
            if ($current - $delta < 0) {
                $delta = $current;
            }

            $offset = $current - $delta;
            $pages = range($offset + 1, $offset + $this->pageRange);
        }

        $proximity = floor($this->pageRange / 2);

        $startPage = $current - $proximity;
        $endPage = $current + $proximity;

        if ($startPage < 1) {
            $endPage = min($endPage + (1 - $startPage), $pageCount);
            $startPage = 1;
        }

        if ($endPage > $pageCount) {
            $startPage = max($startPage - ($endPage - $pageCount), 1);
            $endPage = $pageCount;
        }

        $pageParameterName = sprintf('%s[%s][%s]', GridForm::FORM_NAME, GridForm::DATA_SOURCE_SETTINGS_FORM_NAME, DataSourceSettingsForm::PAGE_FORM_NAME);
        $viewData = [
            'last' => $pageCount,
            'current' => $current,
            'numItemsPerPage' => $this->itemNumberPerPage,
            'first' => 1,
            'pageCount' => $pageCount,
            'totalCount' => $this->totalItemsCount,
            'pageRange' => $this->pageRange,
            'startPage' => $startPage,
            'endPage' => $endPage,
            'pageParameterName' => $pageParameterName
        ];

        if ($current > 1) {
            $viewData['previous'] = $current - 1;
        }

        if ($current < $pageCount) {
            $viewData['next'] = $current + 1;
        }

        $viewData['pagesInRange'] = $pages;
        $viewData['firstPageInRange'] = min($pages);
        $viewData['lastPageInRange'] = max($pages);

        return $viewData;
    }

    public function getPageCount(): int
    {
        return intval(ceil($this->totalItemsCount / $this->itemNumberPerPage));
    }

    public function getTotalItemsCount(): int
    {
        return $this->totalItemsCount;
    }

    public function getCurrentPageNumber(): int
    {
        return $this->currentPageNumber;
    }

    public function getItemNumberPerPage(): int
    {
        return $this->itemNumberPerPage;
    }
}