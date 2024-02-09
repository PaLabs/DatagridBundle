<?php

namespace PaLabs\DatagridBundle\DataSource\Filter;


use PaLabs\DatagridBundle\DataSource\Filter\Registry\FilterRegistry;
use PaLabs\DatagridBundle\Form\Type\EmptyGetForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterCollectionForm extends AbstractType
{

    public function __construct(protected FilterRegistry $filterRegistry)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($options['filters'] as $name => $filterDesc) {
            $filter = $this->filterRegistry->getFilter($filterDesc['filterClass']);
            $formType = $filterDesc['formType']  ?? $filter->formType();
            $formOptions = array_merge($filter->formOptions(), $filterDesc['formOptions']);

            $builder->add($name, $formType, $formOptions);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
       $resolver->setRequired('filters');
    }


    public function getParent(): string
    {
        return EmptyGetForm::class;
    }


}