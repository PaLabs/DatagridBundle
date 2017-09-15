<?php

namespace PaLabs\DatagridBundle\Field\Type\Twig;


use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Type\HtmlOrTextField;
use PaLabs\DatagridBundle\Field\Type\InvalidDataTypeException;
use PaLabs\DatagridBundle\Util\StringUtils;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class TwigField extends HtmlOrTextField
{
    private $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public static function field(string $template, array $data = [], array $options = [])
    {
        return new TwigFieldData($template, $data, $options);
    }

    public function renderHtml(FieldData $data)
    {
        if (!$data instanceof TwigFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        return $this->templating->render($data->getTemplate(), $data->getData());
    }

    public function renderTxt(FieldData $data)
    {
        if (!$data instanceof TwigFieldData) {
            throw new InvalidDataTypeException($data, $this->dataClass());
        }

        $value = $this->renderHtml($data);

        $value = strip_tags($value);
        $value = StringUtils::removeNewLineSymbols($value);
        $value = StringUtils::removeMultiSpaces($value);
        $value = trim($value);
        return $value;
    }

    public function dataClass(): string
    {
        return TwigFieldData::class;
    }
}