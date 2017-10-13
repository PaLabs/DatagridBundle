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

        if(!isset($value[BooleanFilterForm::VALUE_FIELD])) {
            $filterValue = null;
        } else {
            $filterValue = is_bool($value[BooleanFilterForm::VALUE_FIELD]) ? $value[BooleanFilterForm::VALUE_FIELD] : null;
        }
        return new BooleanFilterData($filterValue);
    }
}