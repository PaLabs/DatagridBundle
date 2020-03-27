<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\String;


final class StringFilterOperator
{

    public const OPERATOR_CONTAINS = 'c';
    public const OPERATOR_NOT_CONTAINS = 'nc';
    public const OPERATOR_EMPTY = 'em';
    public const OPERATOR_EQUALS = 'e';
    public const OPERATOR_NOT_EMPTY = 'nem';

    private const ALL_OPERATORS = [
        self::OPERATOR_CONTAINS,
        self::OPERATOR_NOT_CONTAINS,
        self::OPERATOR_EMPTY,
        self::OPERATOR_EQUALS,
        self::OPERATOR_NOT_EMPTY
    ];

    public static function valid(string $operator): bool {
        return in_array($operator, self::ALL_OPERATORS);
    }
}