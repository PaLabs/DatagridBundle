<?php


namespace PaLabs\DatagridBundle\DataTable\Column;


use PaLabs\DatagridBundle\Field\Type\String\StringField;

class ColumnOptions
{
    protected $label;
    protected $group;
    protected $required;
    protected $needDisplayCallback;
    protected $headerBuilder;

    public function __construct(
        string $label,
        string $group = '',
        bool $required = false,
        callable $headerOptionsCallback = null,
        callable $needDisplayCallback = null,
        callable $headerBuilder = null)
    {
        $this->label = $label;
        $this->group = $group;
        $this->required = $required;

        $this->needDisplayCallback = $needDisplayCallback ?? function () {
                return true;
            };
        $this->headerBuilder = $headerBuilder ?? function () {
                return StringField::field($this->label);
            };
    }

    public static function fromArray(array $parameters)
    {
        return new self(
            $parameters['label'],
            $parameters['group'] ?? '',
            $parameters['required'] ?? false,
            $parameters['need_display'] ?? null,
            $parameters['header_builder'] ?? null
        );
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getNeedDisplayCallback(): ?callable
    {
        return $this->needDisplayCallback;
    }

    public function getHeaderBuilder(): ?callable
    {
        return $this->headerBuilder;
    }


}