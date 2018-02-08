<?php


namespace PaLabs\DatagridBundle\DataSource\Order;


class SortBuilder
{
    protected $sorting = [];

    public function add(string $name, string $label, string $group = '', array $options = [])
    {
        $this->checkOrderItemExists($name);
        $this->sorting[$name] = [
            'label' => $label,
            'group' => $group,
            'options' => $options
        ];
        return $this;
    }


    public function getSorting()
    {
        return $this->sorting;
    }

    private function checkOrderItemExists(string $name)
    {
        if (isset($this->sorting[$name])) {
            throw new \Exception(sprintf("Sorting already exists for item name=%s", $name));
        }
    }
}