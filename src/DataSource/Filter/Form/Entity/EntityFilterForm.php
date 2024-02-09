<?php

namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


use PaLabs\DatagridBundle\DataSource\Filter\BaseFilterForm;
use PaLabs\DatagridBundle\Form\Type\EnumForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntityFilterForm extends AbstractType
{
    const OPERATOR_FIELD = 'o';
    const VALUE_FIELD = 'v';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::OPERATOR_FIELD, EnumForm::class, [
                'type' => EntityFilterOperator::class
            ])
            ->add(self::VALUE_FIELD, $options['entity_form'],
                array_merge(['required' => false], $options['entity_options']));

        $builder->addModelTransformer(new EntityFilterModelTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'entity_form' => EntityType::class,
                'entity_options' => [],
            ]);
    }

    public function getParent(): string
    {
        return BaseFilterForm::class;
    }


}