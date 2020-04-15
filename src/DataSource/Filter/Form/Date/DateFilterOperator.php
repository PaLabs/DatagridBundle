<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


use PaLabs\Enum\Enum;

final class DateFilterOperator extends Enum
{

    public static DateFilterOperator
        $OPERATOR_INTERVAL,
        $OPERATOR_CURRENT_DAY,
        $OPERATOR_YESTERDAY,
        $OPERATOR_CURRENT_WEEK,
        $OPERATOR_CURRENT_YEAR;
}
