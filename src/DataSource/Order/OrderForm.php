<?php


namespace PaLabs\DatagridBundle\DataSource\Order;


use PaLabs\DatagridBundle\DataSource\Order\OrderItemForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_add' => true,
            'allow_delete' => true,
            'required' => false,
            'entry_type' => OrderItemForm::class,
        ]);
    }

    public function getParent()
    {
        return CollectionType::class;
    }


}