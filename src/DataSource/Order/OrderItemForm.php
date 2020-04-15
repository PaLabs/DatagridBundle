<?php

namespace PaLabs\DatagridBundle\DataSource\Order;


use PaLabs\DatagridBundle\Form\Type\EnumForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderItemForm extends AbstractType
{
    const FIELD_FORM_NAME = 'f';
    const DIRECTION_FORM_NAME = 'd';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::FIELD_FORM_NAME, ChoiceType::class, [
                'required' => true,
                'choices' => $options['sortFields']
            ])
            ->add(self::DIRECTION_FORM_NAME, EnumForm::class, [
                'required' => true,
                'type' => OrderDirection::class
            ]);
        $builder->addModelTransformer(new CallbackTransformer(
            function (OrderItem $item = null) {
                if ($item == null) {
                    return null;
                }
                return [
                    self::FIELD_FORM_NAME => $item->getField(),
                    self::DIRECTION_FORM_NAME => $item->getDirection()
                ];
            },
            function (array $itemData) {
                return new OrderItem($itemData[self::FIELD_FORM_NAME], $itemData[self::DIRECTION_FORM_NAME]);
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'translation_domain' => 'PaDatagridBundle',
            ])
            ->setRequired([
                'sortFields'
            ]);
    }


}