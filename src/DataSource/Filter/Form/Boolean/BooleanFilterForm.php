<?php

namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Boolean;


use PaLabs\DatagridBundle\DataSource\Filter\BaseFilterForm;
use PaLabs\DatagridBundle\Form\Type\BooleanForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BooleanFilterForm extends AbstractType
{
    const VALUE_FIELD = 'v';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::VALUE_FIELD, BooleanForm::class, ['required' => false]);

        $builder->addModelTransformer(new BooleanFilterModelTransformer());
    }

    public function getParent()
    {
        return BaseFilterForm::class;
    }

}