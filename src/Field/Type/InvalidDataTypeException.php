<?php


namespace PaLabs\DatagridBundle\Field\Type;


use Exception;
use Throwable;

class InvalidDataTypeException extends Exception
{

    public function __construct($data, string $dataClass, $code = 0, Throwable $previous = null)
    {
        $message = sprintf("Invalid data type: must be %s, but given %s", $dataClass, get_class($data));
        parent::__construct($message, $code, $previous);
    }
}