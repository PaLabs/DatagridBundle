<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateFilterModelTransformer  implements DataTransformerInterface
{
    public function transform($value) {
        if ($value == null) {
            return null;
        }
        if(!$value instanceof DateFilterData) {
            throw new TransformationFailedException();
        }

        return $value->toUrlParams();
    }

    public function reverseTransform($value) {
        if($value === null) {
            return null;
        }
        return new DateFilterData($value[DateFilterForm::START_FIELD], $value[DateFilterForm::END_FIELD]);
    }
}