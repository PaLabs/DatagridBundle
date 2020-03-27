<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


final class EntityFilterOperator
{

    public const OPERATOR_NOT_EMPTY = 'nem';
    public const OPERATOR_EMPTY = 'em';
    public const OPERATOR_EQUALS = 'e';
    public const OPERATOR_NOT_EQUALS = 'ne';

    private const ALL_OPERATORS = [
        self::OPERATOR_NOT_EMPTY,
        self::OPERATOR_EMPTY,
        self::OPERATOR_EQUALS,
        self::OPERATOR_NOT_EQUALS
    ];

    public static function valid(string $operator): bool {
        return in_array($operator, self::ALL_OPERATORS);
    }
}