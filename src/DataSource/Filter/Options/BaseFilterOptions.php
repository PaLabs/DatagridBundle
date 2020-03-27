<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Options;


class BaseFilterOptions  implements FilterOptions
{
    public const FILTER_OPTION_FIELD = 'field';

    protected array $formOptions = [];
    protected array $filterOptions = [];

    public function __construct(?string $label = null)
    {
        if($label !== null) {
            $this->formOptions['label'] = $label;
        }
    }

    public function default()
    {
        $this->formOptions['default'] = true;
        return $this;
    }

    public function group(string $group)
    {
        $this->formOptions['group'] = $group;
        return $this;
    }

    public function translationDomain(?string $domain = null) {
        $this->formOptions['translation_domain'] = $domain;
        return $this;
    }

    public function field(string $field) {
        $this->filterOptions[self::FILTER_OPTION_FIELD] = $field;
        return $this;
    }

    public function formOptions(): array
    {
        return $this->formOptions;
    }

    public function filterOptions(): array
    {
        return $this->filterOptions;
    }

}