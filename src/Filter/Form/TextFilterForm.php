<?php

namespace PaLabs\DatagridBundle\Filter\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextFilterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('o', ChoiceType::class, [
                'property_path' => '[operator]',
                'choices' => [
                'operator_contains' => 'contains'
                ]
            ])
            ->add('v', TextType::class, [
                'property_path' => '[value]',
                'required' => false
            ]);
    }


    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['filter_enabled'] = !empty($view->vars['data']['value']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
           'translation_domain' => 'PaDatagridBundle'
       ]);
    }


    public function getParent()
    {
        return FilterFieldForm::class;
    }
    
}