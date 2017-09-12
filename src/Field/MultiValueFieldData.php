<?php


namespace PaLabs\DatagridBundle\Field;


class MultiValueFieldData extends BaseFieldData
{
    protected $values;
    protected $renderOptions;

    public function __construct(array $values, array $renderOptions = [], array $options = [])
    {
        parent::__construct($options);
        $this->values = $values;
        $this->renderOptions = $renderOptions;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getRenderOptions(): array
    {
        return $this->renderOptions;
    }


}