<?php


namespace PaLabs\DatagridBundle\DataSource\Order;


use Exception;

class SortBuilder
{
    protected array $sorting = [];

    public function add(string $name, string $label, string $group = '', array $options = []): static
    {
        $this->checkOrderItemExists($name);
        $this->sorting[$name] = [
            'label' => $label,
            'group' => $group,
            'options' => $options
        ];
        return $this;
    }


    public function getSorting(): array
    {
        return $this->sorting;
    }

    private function checkOrderItemExists(string $name): void
    {
        if (isset($this->sorting[$name])) {
            throw new Exception(sprintf("Sorting already exists for item name=%s", $name));
        }
    }
}