<?php


namespace PaLabs\DatagridBundle\Grid\Form;


use PaLabs\DatagridBundle\Form\Type\EmptyGetForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GridForm extends AbstractType
{
    const FORM_NAME = 'g';
    const DATA_TABLE_SETTINGS_FORM_NAME = 'gs';
    const DATA_SOURCE_SETTINGS_FORM_NAME = 'ds';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       $builder
           ->add(self::DATA_TABLE_SETTINGS_FORM_NAME, $options['dataTableSettings']['type'], array_merge(
               $options['dataTableSettings']['options'], ['property_path' => 'dataTableSettings']))
           ->add(self::DATA_SOURCE_SETTINGS_FORM_NAME, $options['dataSourceSettings']['type'], array_merge(
               $options['dataSourceSettings']['options'], ['property_path' => 'dataSourceSettings']));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
            'data_class' => GridFormData::class
        ])
        ->setRequired([
            'dataTableSettings',
            'dataSourceSettings',
        ]);
    }

    public function getParent(): string
    {
        return EmptyGetForm::class;
    }


}