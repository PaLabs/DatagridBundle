<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


enum DateFilterOperator: string
{
    case OPERATOR_INTERVAL = 'OPERATOR_INTERVAL';
    case OPERATOR_CURRENT_DAY = 'OPERATOR_CURRENT_DAY';
    case OPERATOR_YESTERDAY = 'OPERATOR_YESTERDAY';
    case OPERATOR_CURRENT_WEEK = 'OPERATOR_CURRENT_WEEK';
    case OPERATOR_CURRENT_YEAR = 'OPERATOR_CURRENT_YEAR';
}
