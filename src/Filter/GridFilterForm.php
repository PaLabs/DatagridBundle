<?php

namespace PaLabs\DatagridBundle\Filter;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GridFilterForm extends AbstractType
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
        return FilterForm::class;
    }


}