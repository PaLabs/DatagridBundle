<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\Date;


use PaLabs\DatagridBundle\Filter\FilterFieldForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateFilterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start', $options['dateForm'], $options['dateFormOptions'])
            ->add('end', $options['dateForm'],  $options['dateFormOptions']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['filter_enabled'] = !empty($view->vars['data']['start']) || !empty($view->vars['data']['end']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver
           ->setDefaults([
               'dateForm' => $this->dateForm(),
               'dateFormOptions' => $this->dateFormOptions()
           ]);
    }


    protected function dateForm() {
        return DateType::class;
    }

    protected function dateFormOptions() {
        return [
            'widget' => 'single_text',
            'required' => false
        ];
    }

    public function getParent()
    {
        return FilterFieldForm::class;
    }


}