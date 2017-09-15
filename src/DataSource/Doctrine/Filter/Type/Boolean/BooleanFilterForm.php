<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\Boolean;


use PaLabs\DatagridBundle\Filter\FilterFieldForm;
use PaLabs\DatagridBundle\Form\Type\BooleanForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class BooleanFilterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', BooleanForm::class, ['required' => false]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['filter_enabled'] = is_bool($view->vars['data']['value']);
    }

    public function getParent()
    {
        return FilterFieldForm::class;
    }

}