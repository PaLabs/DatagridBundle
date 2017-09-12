<?php

namespace PaLabs\DatagridBundle;


class GridSettings
{
    /** @var string[] */
    protected $selectedFields = [];

    /**
     * @return self
     */
    public static function defaultSettings()
    {
        return (new static())
            ->setSelectedFields(['id']);
    }

    public function getSelectedFields(): array
    {
        return $this->selectedFields;
    }

    public function setSelectedFields(array $selectedFields)
    {
        $this->selectedFields = $selectedFields;
        return $this;
    }

}