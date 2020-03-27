<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


final class DateFilterOperator
{
    public const OPERATOR_INTERVAL = 'i';
    public const OPERATOR_CURRENT_YEAR = 'cy';
    public const OPERATOR_YESTERDAY = 'yd';
    public const OPERATOR_CURRENT_WEEK = 'cw';
    public const OPERATOR_CURRENT_DAY = 'cd';

    public const PERIOD_OPERATORS = [
        DateFilterOperator::OPERATOR_CURRENT_DAY,
        DateFilterOperator::OPERATOR_YESTERDAY,
        DateFilterOperator::OPERATOR_CURRENT_WEEK,
        DateFilterOperator::OPERATOR_CURRENT_YEAR
    ];

    private const ALL_OPERATORS = [
        self::OPERATOR_INTERVAL,
        self::OPERATOR_CURRENT_YEAR,
        self::OPERATOR_YESTERDAY,
        self::OPERATOR_CURRENT_WEEK,
        self::OPERATOR_CURRENT_DAY
    ];

    public static function valid(string $operator): bool {
        return in_array($operator, self::ALL_OPERATORS);
    }

}