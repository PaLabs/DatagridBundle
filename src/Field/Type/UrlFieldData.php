<?php


namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\BaseFieldData;

class UrlFieldData extends BaseFieldData
{
    protected $url;
    protected $text;
    protected $attr;

    public function __construct(string $url, string $text, array $attr = [], array $options = [])
    {
        parent::__construct($options);
        $this->url = $url;
        $this->text = $text;
        $this->attr = $attr;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAttr(): array
    {
        return $this->attr;
    }


}