<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Boolean;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class BooleanFilterModelTransformer implements DataTransformerInterface
{
    public static function formData(BooleanFilterData $value) {
        return [
            BooleanFilterForm::VALUE_FIELD => $value->getValue(),
        ];
    }

    public function transform($value) {
        if ($value == null) {
            return null;
        }
        if(!$value instanceof BooleanFilterData) {
            throw new TransformationFailedException();
        }

       return self::formData($value);
    }

    public function reverseTransform($value) {
        if($value === null) {
            return null;
        }

        return new BooleanFilterData($value[BooleanFilterForm::VALUE_FIELD] == 0 ? false : true);
    }
}