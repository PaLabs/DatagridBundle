<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EntityFilterModelTransformer implements DataTransformerInterface
{
    public static function formData(EntityFilterData $value) {
        return [
            EntityFilterForm::OPERATOR_FIELD => $value->getOperator(),
            EntityFilterForm::VALUE_FIELD => $value->getValue()
        ];
    }

    public function transform($value) {
        if ($value == null) {
            return null;
        }
        if(!$value instanceof EntityFilterData) {
            throw new TransformationFailedException();
        }

        return self::formData($value);
    }

    public function reverseTransform($value) {
        if($value === null) {
            return null;
        }
        if(empty($value[EntityFilterForm::OPERATOR_FIELD])) {
            throw new TransformationFailedException();
        }
        return new EntityFilterData($value[EntityFilterForm::OPERATOR_FIELD], $value[EntityFilterForm::VALUE_FIELD]);
    }
}