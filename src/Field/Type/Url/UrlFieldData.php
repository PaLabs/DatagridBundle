<?php


namespace PaLabs\DatagridBundle\Field\Type\Url;


use PaLabs\DatagridBundle\Field\Type\BaseFieldData;

class UrlFieldData extends BaseFieldData
{
    protected ?string $url;
    protected ?string $text;
    protected array $attr;

    public function __construct(?string $url = null, ?string $text = null, array $attr = [], array $options = [])
    {
        parent::__construct($options);
        $this->url = $url;
        $this->text = $text;
        $this->attr = $attr;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getAttr(): array
    {
        return $this->attr;
    }


}