<?php


namespace PaLabs\DatagridBundle\Sort;


use PaLabs\DatagridBundle\Form\GridOrderItemForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GridOrderForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_add' => true,
            'allow_delete' => true,
            'required' => false,
            'entry_type' => GridOrderItemForm::class,
        ]);
    }

    public function getParent()
    {
        return CollectionType::class;
    }


}