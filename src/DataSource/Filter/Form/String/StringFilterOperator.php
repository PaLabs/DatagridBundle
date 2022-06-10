<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\String;


enum StringFilterOperator: string
{
    case OPERATOR_CONTAINS = 'OPERATOR_CONTAINS';
    case  OPERATOR_NOT_CONTAINS = 'OPERATOR_NOT_CONTAINS';
    case  OPERATOR_EQUALS = 'OPERATOR_EQUALS';
    case  OPERATOR_EMPTY = 'OPERATOR_EMPTY';
    case  OPERATOR_NOT_EMPTY = 'OPERATOR_NOT_EMPTY';
}

