<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\String;


use PaLabs\Enum\Enum;

final class StringFilterOperator extends Enum
{
    public static StringFilterOperator
        $OPERATOR_CONTAINS,
        $OPERATOR_NOT_CONTAINS,
        $OPERATOR_EMPTY,
        $OPERATOR_EQUALS,
        $OPERATOR_NOT_EMPTY;
}

StringFilterOperator::init();