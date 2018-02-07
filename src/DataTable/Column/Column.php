<?php

namespace PaLabs\DatagridBundle\DataTable\Column;


class Column
{
    protected $headerLabel;
    protected $columnListLabel;
    protected $required;
    protected $needDisplayCallback;
    protected $headerOptionsCallback;
    protected $columnMaker;
    protected $headerBuilder;
    protected $group;

    public function __construct(callable $columnMaker, array $parameters) {
        $this->columnMaker = $columnMaker;

        $this->headerLabel = $parameters['label'];
        $this->columnListLabel = $parameters['column_list_label'] ?? $parameters['label'];
        $this->required = $parameters['required'] ?? false;
        $this->headerOptionsCallback = $parameters['header_options'] ?? null;
        $this->needDisplayCallback = $parameters['need_display'] ?? null;
        $this->headerBuilder = $parameters['header_builder'] ?? null;
        $this->group = $parameters['group'] ?? '';
    }

    public function getHeaderLabel(): string
    {
        return $this->headerLabel;
    }

    public function getColumnListLabel(): string
    {
        return $this->columnListLabel;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getNeedDisplayCallback(): ?callable
    {
        return $this->needDisplayCallback;
    }

    public function getHeaderOptionsCallback(): ?callable
    {
        return $this->headerOptionsCallback;
    }

    public function getColumnMaker(): callable
    {
        return $this->columnMaker;
    }

    public function getHeaderBuilder(): ?callable
    {
        return $this->headerBuilder;
    }

    public function getGroup(): string
    {
        return $this->group;
    }



}