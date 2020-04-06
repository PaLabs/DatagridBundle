<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


use PaLabs\Enum\Enum;

final class EntityFilterOperator extends Enum
{

    public static EntityFilterOperator
        $OPERATOR_NOT_EMPTY,
        $OPERATOR_EMPTY,
        $OPERATOR_EQUALS,
        $OPERATOR_NOT_EQUALS;
    
}

EntityFilterOperator::init();