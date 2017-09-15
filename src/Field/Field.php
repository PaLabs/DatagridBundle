<?php

namespace PaLabs\DatagridBundle\Field;


interface Field
{
    public function render(FieldData $data, string $format);

    public function dataClass() : string;
}