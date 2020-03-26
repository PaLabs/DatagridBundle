<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter;


use PaLabs\DatagridBundle\DataSource\Filter\Options\BaseFilterOptions;

class FilterHelper
{
    public static function fieldName(string $name, array $options): string
    {
        if (isset($options[BaseFilterOptions::FILTER_OPTION_FIELD])) {
            return $options[BaseFilterOptions::FILTER_OPTION_FIELD];
        }
        return sprintf('entity.%s', $name);
    }

    public static function parameterName($name)
    {
        return $name . '_criteria';
    }

}