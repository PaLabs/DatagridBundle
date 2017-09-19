<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\String;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringFilterModelTransformer implements DataTransformerInterface
{
    public function transform($value) {
        if ($value == null) {
            return null;
        }
        if(!$value instanceof StringFilterData) {
            throw new TransformationFailedException();
        }

        return [
            StringFilterForm::OPERATOR_FIELD => $value->getOperator(),
            StringFilterForm::VALUE_FIELD => $value->getValue()
        ];
    }

    public function reverseTransform($value) {
        if($value === null) {
            return null;
        }
        if(empty($value[StringFilterForm::OPERATOR_FIELD])) {
            throw new TransformationFailedException();
        }
        return new StringFilterData($value[StringFilterForm::OPERATOR_FIELD], $value[StringFilterForm::VALUE_FIELD]);
    }
}