<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


enum EntityFilterOperator: string
{
    case OPERATOR_EQUALS = 'OPERATOR_EQUALS';
    case OPERATOR_NOT_EQUALS = 'OPERATOR_NOT_EQUALS';
    case  OPERATOR_NOT_EMPTY = 'OPERATOR_NOT_EMPTY';
    case OPERATOR_EMPTY = 'OPERATOR_EMPTY';
}

