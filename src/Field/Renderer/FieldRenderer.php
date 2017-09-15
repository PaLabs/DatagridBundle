<?php

namespace PaLabs\DatagridBundle\Field\Renderer;


use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Renderer\FieldRenderResult;
use PaLabs\DatagridBundle\Field\Renderer\MultiColumnFieldData;
use PaLabs\DatagridBundle\Field\Renderer\MultiValueFieldData;
use PaLabs\DatagridBundle\Field\Registry\FieldRegistry;
use PaLabs\DatagridBundle\Grid\GridOptions;

class FieldRenderer
{
    private $registry;

    public function __construct(FieldRegistry $registry)
    {
        $this->registry = $registry;
    }

    public static function multiValueField(array $values, $wrapNewLine = false, array $options = [])
    {
        return new MultiValueFieldData($values, ['wrap_new_line' => $wrapNewLine], $options);
    }

    public static function multiColumnField(array $values, array $options = [])
    {
        return new MultiColumnFieldData($values, $options);
    }


    public function renderField(FieldData $fieldData, string $displayFormat)
    {
        if ($fieldData instanceof MultiValueFieldData) {
            return [$this->renderMultiValueField($fieldData, $displayFormat)];
        } elseif ($fieldData instanceof MultiColumnFieldData) {
            return $this->renderMultiColumnField($fieldData, $displayFormat);
        } else {
            $field = $this->registry->getField($fieldData);
            $result = [new FieldRenderResult($fieldData, $field->render($fieldData, $displayFormat))];
            return $result;
        }
    }

    private function renderMultiColumnField(MultiColumnFieldData $data, $format)
    {
        $parts = array_map(function ($nestedFieldDesc) use ($format) {
            return $this->renderField($nestedFieldDesc, $format);
        }, $data->getColumns());
        return $this->flatten2($parts);
    }

    private function renderMultiValueField(MultiValueFieldData $data, $format)
    {
        $parts = array_map(function ($nestedFieldDesc) use ($format) {
            return $this->renderField($nestedFieldDesc, $format);
        }, $data->getValues());

        $parts = $this->flatten2($parts);
        $partsContent = array_map(function (FieldRenderResult $renderResult) {
            return $renderResult->getRenderedContent();
        }, $parts);

        if ($data->getRenderOptions()['wrap_new_line']) {
            if($format == GridOptions::RENDER_FORMAT_HTML) {
                $content = implode('<br/>', $partsContent);
            } else {
                $content = implode(', ', $partsContent);
            }
        } else {
            $content = implode(', ', $partsContent);
        }
        return new FieldRenderResult($data, $content);
    }

    private function flatten2(array $data)
    {
        $result = [];
        foreach ($data as $parts) {
            foreach ($parts as $item) {
                $result[] = $item;
            }
        }
        return $result;
    }


}