<?php

namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Integer;


use PaLabs\DatagridBundle\DataSource\Filter\BaseFilterForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class IntegerFilterForm extends AbstractType
{
    const VALUE_FIELD = 'v';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::VALUE_FIELD, TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => '1990, 1992-1995, 2000-']
            ]);

        $builder->addModelTransformer(new IntegerFilterModelTransformer());
    }

    public function getParent(): string
    {
        return BaseFilterForm::class;
    }

}