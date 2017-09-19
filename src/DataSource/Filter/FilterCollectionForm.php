<?php

namespace PaLabs\DatagridBundle\DataSource\Filter;


use PaLabs\DatagridBundle\Form\Type\EmptyGetForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterCollectionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['filters'] as $name => $filterDesc) {
            $builder->add($name, $filterDesc['formType'], $filterDesc['formOptions']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setRequired('filters');
    }


    public function getParent()
    {
        return EmptyGetForm::class;
    }


}