<?php

namespace PaLabs\DatagridBundle\DataSource\Filter\Form\String;


use PaLabs\DatagridBundle\DataSource\Filter\BaseFilterForm;
use PaLabs\DatagridBundle\Form\Type\EnumForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class StringFilterForm extends AbstractType
{
    const OPERATOR_FIELD = 'o';
    const VALUE_FIELD = 'v';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::OPERATOR_FIELD, EnumForm::class, [
                'type' => StringFilterOperator::class
            ])
            ->add(self::VALUE_FIELD, TextType::class, [
                'required' => false
            ]);

        $builder->addModelTransformer(new StringFilterModelTransformer());
    }

    public function getParent(): string
    {
        return BaseFilterForm::class;
    }

}