<?php

namespace PaLabs\DatagridBundle\DataSource\Filter;


use PaLabs\DatagridBundle\DataSource\Filter\Registry\FilterRegistry;
use PaLabs\DatagridBundle\Form\Type\EmptyGetForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterCollectionForm extends AbstractType
{
    protected FilterRegistry $filterRegistry;

    public function __construct(FilterRegistry $filterRegistry)
    {
        $this->filterRegistry = $filterRegistry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['filters'] as $name => $filterDesc) {
            $filter = $this->filterRegistry->getFilter($filterDesc['filterClass']);
            $formType = $filterDesc['formType']  ?? $filter->formType();
            $formOptions = array_merge($filter->formOptions(), $filterDesc['formOptions']);

            $builder->add($name, $formType, $formOptions);
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