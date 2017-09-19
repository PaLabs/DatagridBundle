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

        return [
            DateFilterForm::START_FIELD => $value->getStartDate(),
            DateFilterForm::END_FIELD => $value->getEndDate()
        ];
    }

    public function reverseTransform($value) {
        if($value === null) {
            return null;
        }
        return new DateFilterData($value[DateFilterForm::START_FIELD], $value[DateFilterForm::END_FIELD]);
    }
}