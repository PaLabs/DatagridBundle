<?php


namespace PaLabs\DatagridBundle\DataTable\Service;


use Exception;
use PaLabs\DatagridBundle\DataTable\Column\Column;
use PaLabs\DatagridBundle\DataTable\ColumnMakerContext;
use ReflectionFunction;
use ReflectionParameter;

class ColumnMakerCaller
{
    const CALL_TYPE_DEFAULT = 1;
    const CALL_TYPE_ONLY_CONTEXT = 2;

    protected array $columnMakersCallTypes = [];

    public function __construct(array $columns)
    {
        foreach ($columns as $column) {
            /** @var Column $column */
            $columnMaker = $column->getColumnMaker();

            $r = new ReflectionFunction($columnMaker);
            $params = $r->getParameters();

            $callType = self::CALL_TYPE_DEFAULT;
            if ($this->argumentsIsOnlyContext($params)) {
                $callType = self::CALL_TYPE_ONLY_CONTEXT;

            }
            $this->columnMakersCallTypes[$column->getName()] = $callType;

        }
    }

    /**
     * @param ReflectionParameter[] $parameters
     * @return bool
     */
    private function argumentsIsOnlyContext(array $parameters): bool
    {

        if (count($parameters) == 1) {
            $firstParameter = $parameters[0];
            $parameterClass = $firstParameter->getClass();
            if ($parameterClass === null) {
                return false;
            }
            if ($parameterClass->getName() == ColumnMakerContext::class) {
                return true;
            }
        }
        return false;
    }

    public function call(Column $column, ColumnMakerContext $context)
    {
        $columnMaker = $column->getColumnMaker();

        switch ($this->columnMakersCallTypes[$column->getName()]) {
            case self::CALL_TYPE_DEFAULT:
                $row = $context->getRow();
                if (is_array($row) && isset($row[0]) && is_object($row[0])) {
                    $entityObj = $row[0];
                    return $columnMaker($entityObj, $context);
                } else {
                    return $columnMaker($row, $context);
                }
            case self::CALL_TYPE_ONLY_CONTEXT:
                return $columnMaker($context);
            default:
                throw new Exception(sprintf("Unknown call type: %s", $this->columnMakersCallTypes[$column->getName()]));
        }

    }
}