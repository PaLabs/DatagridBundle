<?php

namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


use PaLabs\DatagridBundle\DataSource\Filter\BaseFilterForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntityFilterForm extends AbstractType
{
    const OPERATOR_FIELD = 'o';
    const VALUE_FIELD = 'v';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::OPERATOR_FIELD, ChoiceType::class, [
                'choices' => [
                    'equals' => EntityFilterOperator::OPERATOR_EQUALS,
                    'not_equals' => EntityFilterOperator::OPERATOR_NOT_EQUALS,
                    'operator_empty' => EntityFilterOperator::OPERATOR_EMPTY,
                    'operator_not_empty' => EntityFilterOperator::OPERATOR_NOT_EMPTY,
                ]
            ])
            ->add(self::VALUE_FIELD, $options['entity_form'],
                array_merge(['required' => false], $options['entity_options']));

        $builder->addModelTransformer(new EntityFilterModelTransformer());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'entity_form' => EntityType::class,
                'entity_options' => [],
                'translation_domain' => 'PaDatagridBundle'
            ]);
    }

    public function getParent()
    {
        return BaseFilterForm::class;
    }


}