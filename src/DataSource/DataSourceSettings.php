<?php

namespace PaLabs\DatagridBundle\DataSource;


class DataSourceSettings
{
    const DEFAULT_PER_PAGE = 20;
    const DEFAULT_PAGE_NUMBER = 1;

    /** @var  array */
    protected $filters;

    /** @var array */
    protected $order;

    /** @var int */
    protected $perPage;

    /** @var  int */
    protected $page;

    /**
     * @return self
     */
    public static function defaultSettings()
    {
        /** @var DataSourceSettings $self */
        $self = (new static());
        return $self
            ->setFilters([])
            ->setOrder([])
            ->setPerPage(self::DEFAULT_PER_PAGE)
            ->setPage(self::DEFAULT_PAGE_NUMBER);
    }

    public function getOrder(): array
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function setFilters($filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page)
    {
        $this->page = $page;
        return $this;
    }


}