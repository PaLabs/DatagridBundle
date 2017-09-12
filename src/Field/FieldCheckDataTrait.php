<?php


namespace PaLabs\DatagridBundle\Field;


trait FieldCheckDataTrait
{

    private function checkDataType($data, $dataClass) {
        if(!$data instanceof $dataClass) {
            throw new \Exception(sprintf("Invalid data type: must be %s, but given %s", $dataClass, get_class($data)));
        }
    }
}