<?php

namespace PaLabs\DatagridBundle\DataSource;


class DataSourceSettings
{
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
            ->setPerPage(20)
            ->setPage(1)
            ->setOrder([
                new OrderItem('entity.id', OrderItem::DESC)
            ]);
    }

    public function toUrlParams()
    {
        $data = ['filters' => $this->filters, 'order' => $this->order, 'perPage' => $this->perPage];
        array_walk_recursive($data, function (&$value) {
             if (is_object($value)) {
                $value = $value->getId();
            }
        });
        return $data;
    }

    public function getOrder()
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