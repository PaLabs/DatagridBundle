<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


class DateFilterOperators
{
    private array $periodOperators;

    private static ?DateFilterOperators $instance = null;

    private function __construct()
    {
        $this->periodOperators = [
            DateFilterOperator::$OPERATOR_CURRENT_DAY,
            DateFilterOperator::$OPERATOR_YESTERDAY,
            DateFilterOperator::$OPERATOR_CURRENT_WEEK,
            DateFilterOperator::$OPERATOR_CURRENT_YEAR
        ];
    }

    public function isPeriodOperator(DateFilterOperator $operator): bool {
        return in_array($operator, $this->periodOperators);
    }

    public static function getInstance(): DateFilterOperators {
        if(self::$instance === null) {
            self::$instance = new DateFilterOperators();
        }
        return self::$instance;
    }


}