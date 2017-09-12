<?php

namespace PaLabs\DatagridBundle\Field;


interface Field
{
    public function render(FieldData $data, String $displayFormat);

    public function dataClass() : string;
}