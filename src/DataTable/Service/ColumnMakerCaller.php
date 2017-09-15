<?php


namespace PaLabs\DatagridBundle\DataTable\Service;


use PaLabs\DatagridBundle\DataTable\ColumnMakerContext;

class ColumnMakerCaller
{
    const  CALL_TYPE_DEFAULT = 1;
    const CALL_TYPE_ONLY_CONTEXT = 2;

    protected $columnMakersCallTypes = [];

    public function __construct(array $columns)
    {
        foreach ($columns as $columnName => $column) {
            /** @var \PaLabs\DatagridBundle\DataTable\Column\Column $column */
            $columnMaker = $column->columnMaker;

            $r = new \ReflectionFunction($columnMaker);
            $params = $r->getParameters();

            $callType = self::CALL_TYPE_DEFAULT;
            if ($this->argumentsIsOnlyContext($params)) {
                $callType = self::CALL_TYPE_ONLY_CONTEXT;

            }
            $this->columnMakersCallTypes[$columnName] = $callType;

        }
    }

    public function call(string $columnName, callable $columnMaker, ColumnMakerContext $context)
    {
        switch ($this->columnMakersCallTypes[$columnName]) {
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
                throw new \Exception(sprintf("Unknown call type: %s", $this->columnMakersCallTypes[$columnName]));
        }

    }

    /**
     * @param \ReflectionParameter[] $parameters
     * @return bool
     */
    private function argumentsIsOnlyContext(array $parameters)
    {

        if (count($parameters) == 1) {
            $firstParameter = $parameters[0];
            $parameterClass = $firstParameter->getClass();
            if($parameterClass === null) {
                return false;
            }
            if ($parameterClass->getName() == ColumnMakerContext::class) {
                return true;
            }
        }
        return false;
    }
}