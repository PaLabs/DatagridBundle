<?php

namespace PaLabs\DatagridBundle\Filter;


class FilterHelper
{
    public static function fieldName($name, array $options)
    {
        if (isset($options['field'])) {
            $fieldName = $options['field'];
        } else {
            $fieldName = sprintf('%s.%s', self::entityAlias($options), $name);
        }

        return $fieldName;
    }

    public static function entityAlias(array $options)
    {
        if (isset($options['entityAlias'])) {
            return $options['entityAlias'];
        }
        return 'entity';
    }

    public static function parameterName($name, array $options)
    {
        $parameterName = $name . '_criteria';
        return $parameterName;
    }

}