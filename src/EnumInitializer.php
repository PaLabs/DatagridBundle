<?php


namespace PaLabs\DatagridBundle;


use PaLabs\DatagridBundle\DataSource\Filter\Form\Date\DateFilterOperator;
use PaLabs\DatagridBundle\DataSource\Filter\Form\Entity\EntityFilterOperator;
use PaLabs\DatagridBundle\DataSource\Filter\Form\String\StringFilterOperator;
use PaLabs\DatagridBundle\DataSource\Order\OrderDirection;
use PaLabs\Enum\Enum;

class EnumInitializer
{

    public static function init(): void
    {
        $enums = [
            DateFilterOperator::class,
            EntityFilterOperator::class,
            StringFilterOperator::class,
            OrderDirection::class
        ];

        /** @var Enum $enum */
        foreach ($enums as $enum) {
            $enum::init();
        }
    }
}