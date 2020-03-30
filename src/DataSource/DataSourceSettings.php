<?php

namespace PaLabs\DatagridBundle\DataSource;


class DataSourceSettings
{
    const DEFAULT_PER_PAGE = 20;
    const DEFAULT_PAGE_NUMBER = 1;

    protected array $filters = [];
    protected array $order = [];
    protected int $perPage = self::DEFAULT_PER_PAGE;
    protected int $page = self::DEFAULT_PAGE_NUMBER;

    /**
     * @return self
     */
    public static function defaultSettings()
    {
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

    public function setOrder(array $order)
    {
        $this->order = $order;
        return $this;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function setPerPage(int $perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function setFilters(array $filters)
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