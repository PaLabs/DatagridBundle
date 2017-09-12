<?php

namespace PaLabs\DatagridBundle\Field;


class FieldRenderUtils
{
    public static function renderBoolLabel(bool $data) {
        if ($data === true) {
            return '<span class="label label-success">Да</span>';
        } else {
            return '<span class="label label-danger">Нет</span>';
        }
    }
}