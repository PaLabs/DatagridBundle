<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\Entity;


use PaLabs\DatagridBundle\Filter\FilterFieldForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntityFilterForm extends AbstractType
{
    const OPERATOR_FIELD = 'o';
    const VALUE_FIELD = 'v';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::OPERATOR_FIELD, ChoiceType::class, [
                'choices' => [
                    'equals' => EntityFilter::OPERATOR_EQUALS,
                    'not_equals' => EntityFilter::OPERATOR_NOT_EQUALS
                ]
            ])
            ->add(self::VALUE_FIELD, $options['value_form'],
                array_merge(['required' => false], $options['entity_options']));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['filter_enabled'] = !empty($view->vars['data']['value']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'value_form' => $this->defaultEntityForm(),
                'entity_options' => [],
                'translation_domain' => 'PaDatagridBundle'
            ]);
    }

    protected function defaultEntityForm()
    {
        return EntityType::class;
    }

    public function getParent()
    {
        return FilterFieldForm::class;
    }


}