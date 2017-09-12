<?php

namespace PaLabs\DatagridBundle\Field\Type;


use PaLabs\DatagridBundle\Field\Field;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\FieldCheckDataTrait;
use PaLabs\DatagridBundle\Field\HtmlOrTextField;
use PaLabs\DatagridBundle\Util\StringUtils;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class TwigField extends HtmlOrTextField
{
    use FieldCheckDataTrait;

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
        $this->checkDataType($data, $this->dataClass());
        /** @var TwigFieldData  $data */

        return $this->templating->render($data->getTemplate(), $data->getData());
    }

    public function renderTxt(FieldData $data)
    {
        $this->checkDataType($data, $this->dataClass());
        /** @var TwigFieldData  $data */

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