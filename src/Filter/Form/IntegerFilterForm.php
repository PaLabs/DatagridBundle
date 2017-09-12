<?php

namespace PaLabs\DatagridBundle\Filter\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class IntegerFilterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', TextType::class, ['required' => false, 'attr' => ['placeholder' => '1990, 1992-1995, 2000-']]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['filter_enabled'] = isset($view->vars['data']['value']);
    }


    public function getParent()
    {
        return FilterFieldForm::class;
    }

}