<?php


namespace PaLabs\DatagridBundle;


use PaLabs\DatagridBundle\Filter\FilterForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GridForm extends AbstractType
{
    const FORM_NAME = 'g';
    const GRID_SETTINGS_FORM_NAME = 'gs';
    const DATA_SOURCE_SETTINGS_FORM_NAME = 'ds';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add(self::GRID_SETTINGS_FORM_NAME, $options['gridSettings']['type'], array_merge(
               $options['gridSettings']['options'], ['property_path' => 'gridSettings']))
           ->add(self::DATA_SOURCE_SETTINGS_FORM_NAME, $options['dataSourceSettings']['type'], array_merge(
               $options['dataSourceSettings']['options'], ['property_path' => 'dataSourceSettings']));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
            'data_class' => GridFormData::class
        ])
        ->setRequired([
            'gridSettings',
            'dataSourceSettings',
        ]);
    }

    public function getParent()
    {
        return FilterForm::class;
    }


}