<?php


namespace PaLabs\DatagridBundle\Field\Renderer;


use PaLabs\DatagridBundle\Field\Type\BaseFieldData;

class MultiValueFieldData extends BaseFieldData
{
    protected array $values;
    protected array $renderOptions;

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