<?php

namespace PaLabs\DatagridBundle\DataSource\Order;


use PaLabs\DatagridBundle\DataSource\Order\OrderItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderItemForm extends AbstractType
{
    const FIELD_FORM_NAME = 'f';
    const DIRECTION_FORM_NAME = 'd';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::FIELD_FORM_NAME, ChoiceType::class, [
                'property_path' => 'field',
                'required' => true,
                'choices' => $options['sortFields']
            ])
            ->add(self::DIRECTION_FORM_NAME, ChoiceType::class, [
                'property_path' => 'direction',
                'required' => true,
                'choices' => [
                    'order_asc' => OrderItem::ASC,
                    'order_desc' => OrderItem::DESC
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => OrderItem::class,
                'translation_domain' => 'PaDatagridBundle',
                'empty_data' => function (FormInterface $form) {
                    return new OrderItem($form->get(self::FIELD_FORM_NAME)->getData(), $form->get(self::DIRECTION_FORM_NAME)->getData());
                }
            ])
            ->setRequired(['sortFields']);
    }


}