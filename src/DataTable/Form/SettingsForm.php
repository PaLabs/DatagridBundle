<?php

namespace PaLabs\DatagridBundle\DataTable\Form;


use PaLabs\DatagridBundle\DataTable\Form\ColumnsForm;
use PaLabs\DatagridBundle\Form\Type\EmptyGetForm;
use PaLabs\DatagridBundle\Form;
use PaLabs\DatagridBundle\DataTable\DataTableSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsForm extends AbstractType
{
    const FIELDS_FORM_NAME = 'f';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::FIELDS_FORM_NAME, ColumnsForm::class, [
                'property_path' => 'selectedFields',
                'fields' => $options['fields']
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(['data_class' => DataTableSettings::class])
            ->setRequired(['fields']);
    }

}