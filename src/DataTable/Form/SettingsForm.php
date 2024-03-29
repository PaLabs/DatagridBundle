<?php

namespace PaLabs\DatagridBundle\DataTable\Form;


use PaLabs\DatagridBundle\DataTable\DataTableSettings;
use PaLabs\DatagridBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsForm extends AbstractType
{
    const FIELDS_FORM_NAME = 'fi';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::FIELDS_FORM_NAME, ColumnsForm::class, [
                'property_path' => 'selectedFields',
                'fields' => $options['fields']
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => DataTableSettings::class
            ])
            ->setRequired([
                'fields'
            ]);
    }

}