<?php

namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\EntityFilter;
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

    public static function formData($value, string $operator = EntityFilter::OPERATOR_EQUALS)
    {
        return EntityFilterModelTransformer::formData(new EntityFilterData($operator, $value));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::OPERATOR_FIELD, ChoiceType::class, [
                'choices' => [
                    'equals' => EntityFilter::OPERATOR_EQUALS,
                    'not_equals' => EntityFilter::OPERATOR_NOT_EQUALS
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