<?php


namespace PaLabs\DatagridBundle\Field\Type\Twig;


use PaLabs\DatagridBundle\Field\Type\BaseFieldData;

class TwigFieldData extends BaseFieldData
{
    protected $template;
    protected $data;

    public function __construct(string $template, array $data = [], array $options = [])
    {
        parent::__construct($options);
        $this->template = $template;
        $this->data = $data;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getData(): array
    {
        return $this->data;
    }


}