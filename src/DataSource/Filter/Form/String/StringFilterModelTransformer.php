<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\String;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringFilterModelTransformer implements DataTransformerInterface
{
    public function transform($value): mixed {
        if ($value == null) {
            return null;
        }
        if(!$value instanceof StringFilterData) {
            throw new TransformationFailedException();
        }

        return $value->toUrlParams();
    }

    public function reverseTransform($value): mixed {
        if($value === null) {
            return null;
        }
        if(empty($value[StringFilterForm::OPERATOR_FIELD])) {
            throw new TransformationFailedException();
        }
        return new StringFilterData($value[StringFilterForm::OPERATOR_FIELD], $value[StringFilterForm::VALUE_FIELD]);
    }
}