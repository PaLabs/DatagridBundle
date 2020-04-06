<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


use PaLabs\Enum\Enum;

final class DateFilterOperator extends Enum
{

    public static DateFilterOperator
        $OPERATOR_INTERVAL,
        $OPERATOR_CURRENT_YEAR,
        $OPERATOR_YESTERDAY,
        $OPERATOR_CURRENT_WEEK,
        $OPERATOR_CURRENT_DAY;

    public static array $PERIOD_OPERATORS;

}
DateFilterOperator::init();

DateFilterOperator::$PERIOD_OPERATORS = [
    DateFilterOperator::$OPERATOR_CURRENT_DAY,
    DateFilterOperator::$OPERATOR_YESTERDAY,
    DateFilterOperator::$OPERATOR_CURRENT_WEEK,
    DateFilterOperator::$OPERATOR_CURRENT_YEAR
];