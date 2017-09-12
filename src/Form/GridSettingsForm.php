<?php

namespace PaLabs\DatagridBundle\Form;


use PaLabs\DatagridBundle\Filter\FilterForm;
use PaLabs\DatagridBundle\Form;
use PaLabs\DatagridBundle\GridSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GridSettingsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('f', Form\GridColumnsForm::class, [
                'property_path' => 'selectedFields',
                'fields' => $options['fields']
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(['data_class' => GridSettings::class])
            ->setRequired(['fields']);
    }

}