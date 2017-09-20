<?php


namespace PaLabs\DatagridBundle\DataSource\Filter;


use Throwable;

class InvalidFilterDataException extends \Exception
{

    public function __construct(string $filterDataClass, $filterDataObj, $code = 0, Throwable $previous = null)
    {
        $message = sprintf("Invalid filter data: must be instance of %s, but is %s", $filterDataClass, get_class($filterDataObj));
        parent::__construct($message, $code, $previous);
    }
}