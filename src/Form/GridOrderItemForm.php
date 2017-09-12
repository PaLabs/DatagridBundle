<?php

namespace PaLabs\DatagridBundle\Form;


use PaLabs\DatagridBundle\DataSource\OrderItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GridOrderItemForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('f', ChoiceType::class, [
                'property_path' => 'field',
                'required' => true,
                'choices' => $options['sortFields']
            ])
            ->add('d', ChoiceType::class, [
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
                    return new OrderItem($form->get('f')->getData(), $form->get('d')->getData());
                }
            ])
            ->setRequired(['sortFields']);
    }


}