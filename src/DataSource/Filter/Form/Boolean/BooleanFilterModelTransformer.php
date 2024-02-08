<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Boolean;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class BooleanFilterModelTransformer implements DataTransformerInterface
{
    public function transform($value): mixed {
        if ($value == null) {
            return null;
        }
        if(!$value instanceof BooleanFilterData) {
            throw new TransformationFailedException();
        }

       return $value->toUrlParams();
    }

    public function reverseTransform($value): mixed {
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