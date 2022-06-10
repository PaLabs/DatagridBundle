<?php


namespace PaLabs\DatagridBundle\Grid\UrlBuilder;


use Exception;
use PaLabs\DatagridBundle\DataSource\DataSourceSettingsForm;
use PaLabs\DatagridBundle\DataSource\Filter\FilterDataInterface;
use PaLabs\DatagridBundle\DataSource\Order\OrderItem;
use PaLabs\DatagridBundle\DataSource\Order\OrderItemForm;

class GridDataSourceUrlParameters
{
    protected array $filters = [];
    protected array $order = [];
    protected ?int $page = null;
    protected ?int $perPage = null;

    public function build(): array
    {
        $parameters = [];

        if (!empty($this->filters)) {
            $parameters[DataSourceSettingsForm::FILTERS_FORM_NAME] = $this->filters;
        }
        if (!empty($this->order)) {
            $parameters[DataSourceSettingsForm::ORDER_FORM_NAME] = $this->order;
        }
        if ($this->perPage !== null) {
            $parameters[DataSourceSettingsForm::PER_PAGE_FORM_NAME] = $this->perPage;
        }
        if ($this->page !== null) {
            $parameters[DataSourceSettingsForm::PAGE_FORM_NAME] = $this->page;
        }

        return $parameters;
    }


    public function addFilter(string $name, FilterDataInterface $filterData): self
    {
        if (isset($this->filters[$name])) {
            throw new Exception(sprintf("Filter data %s already set", $name));
        }
        $this->filters[$name] = $filterData->toUrlParams();
        return $this;
    }

    public function addFilters(array $filters): self {
        foreach($filters as $name => $filterData) {
            if($filterData !== null) {
                $this->addFilter($name, $filterData);
            }
        }
        return $this;
    }

    public function addOrder(OrderItem $orderItem): self
    {
        $this->order[] = [
            OrderItemForm::FIELD_FORM_NAME => $orderItem->getField(),
            OrderItemForm::DIRECTION_FORM_NAME => $orderItem->getDirection()->value
        ];
        return $this;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;
        return $this;
    }

    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;
        return $this;
    }


}