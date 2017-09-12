<?php


namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\BaseFieldData;

class StringFieldData extends BaseFieldData
{
    protected $value;
    protected $renderOptions;

   public function __construct(string $value, array $renderOptions = [], array $options = [])
   {
       parent::__construct($options);
       $this->value = $value;
       $this->renderOptions = $renderOptions;
   }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getRenderOptions(): array
    {
        return $this->renderOptions;
    }




}