<?php

namespace PaLabs\DatagridBundle\DataSource\Filter;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseFilterForm extends AbstractType
{

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        /** @var FilterDataInterface $data */
        $data = $form->getData();

        $view->vars['default'] = $options['default'];
        $view->vars['filter_enabled'] = $data !== null && $data->isEnabled();
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'required' => false,
            'default' => false
        ]);

    }


}