<?php

namespace PaLabs\DatagridBundle\Field;


interface Field
{
    public function render(FieldData $data, string $format): mixed;

    public function dataClass(): string;
}