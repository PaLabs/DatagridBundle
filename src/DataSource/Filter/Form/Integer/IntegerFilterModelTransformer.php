<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Integer;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class IntegerFilterModelTransformer implements DataTransformerInterface
{
    public static function formData(IntegerFilterData $value) {
        return [
            IntegerFilterForm::VALUE_FIELD => $value->getValue(),
        ];
    }

    public function transform($value) {
        if ($value == null) {
            return null;
        }
        if(!$value instanceof IntegerFilterData) {
            throw new TransformationFailedException();
        }

        return self::formData($value);
    }

    public function reverseTransform($value) {
        if($value === null) {
            return null;
        }

        return new IntegerFilterData($value[IntegerFilterForm::VALUE_FIELD]);
    }
}