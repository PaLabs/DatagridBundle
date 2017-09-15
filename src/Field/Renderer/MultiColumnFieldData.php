<?php


namespace PaLabs\DatagridBundle\Field\Renderer;


use PaLabs\DatagridBundle\Field\Type\BaseFieldData;

class MultiColumnFieldData extends BaseFieldData
{

    protected $columns;

    public function __construct(array $columns, array $options = [])
    {
        parent::__construct($options);
        $this->columns = $columns;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }


}