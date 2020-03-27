<?php

namespace PaLabs\DatagridBundle\DataSource\Filter\Form\String;


use PaLabs\DatagridBundle\DataSource\Filter\BaseFilterForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StringFilterForm extends AbstractType
{
    const OPERATOR_FIELD = 'o';
    const VALUE_FIELD = 'v';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::OPERATOR_FIELD, ChoiceType::class, [
                'choices' => [
                    'operator_contains' => StringFilterOperator::OPERATOR_CONTAINS,
                    'operator_not_contains' => StringFilterOperator::OPERATOR_NOT_CONTAINS,
                    'operator_equals' => StringFilterOperator::OPERATOR_EQUALS,
                    'operator_empty' => StringFilterOperator::OPERATOR_EMPTY,
                    'operator_not_empty' => StringFilterOperator::OPERATOR_NOT_EMPTY,
                ]
            ])
            ->add(self::VALUE_FIELD, TextType::class, [
                'required' => false
            ]);

        $builder->addModelTransformer(new StringFilterModelTransformer());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'PaDatagridBundle',
        ]);
    }


    public function getParent()
    {
        return BaseFilterForm::class;
    }

}