<?php

namespace PaLabs\DatagridBundle\Field\Renderer;


use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Registry\FieldRegistry;
use PaLabs\DatagridBundle\Grid\GridOptions;

class FieldRenderer
{

    public function __construct(private readonly FieldRegistry $registry)
    {
    }

    public static function multiValueField(array $values, $wrapNewLine = false, array $options = []): MultiValueFieldData
    {
        return new MultiValueFieldData($values, ['wrap_new_line' => $wrapNewLine], $options);
    }

    public static function multiColumnField(array $values, array $options = []): MultiColumnFieldData
    {
        return new MultiColumnFieldData($values, $options);
    }


    public function renderField(FieldData $fieldData, string $displayFormat): array
    {
        if ($fieldData instanceof MultiValueFieldData) {
            return [$this->renderMultiValueField($fieldData, $displayFormat)];
        } elseif ($fieldData instanceof MultiColumnFieldData) {
            return $this->renderMultiColumnField($fieldData, $displayFormat);
        } else {
            $field = $this->registry->getField($fieldData);
            return [new FieldRenderResult($fieldData, $field->render($fieldData, $displayFormat))];
        }
    }

    private function renderMultiColumnField(MultiColumnFieldData $data, $format): array
    {
        $parts = array_map(
            fn($nestedFieldDesc) => $this->renderField($nestedFieldDesc, $format),
            $data->getColumns()
        );
        return $this->flatten2($parts);
    }

    private function renderMultiValueField(MultiValueFieldData $data, $format): FieldRenderResult
    {
        $parts = array_map(
            fn($nestedFieldDesc) => $this->renderField($nestedFieldDesc, $format),
            $data->getValues()
        );

        $parts = $this->flatten2($parts);
        $partsContent = array_map(fn(FieldRenderResult $renderResult) => $renderResult->getRenderedContent(), $parts);

        if ($data->getRenderOptions()['wrap_new_line']) {
            if ($format == GridOptions::RENDER_FORMAT_HTML) {
                $content = implode('<br/>', $partsContent);
            } else {
                $content = implode(', ', $partsContent);
            }
        } else {
            $content = implode(', ', $partsContent);
        }
        return new FieldRenderResult($data, $content);
    }

    private function flatten2(array $data): array
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