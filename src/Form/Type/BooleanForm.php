<?php


namespace PaLabs\DatagridBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooleanForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'choices' => [
                    'Да' => true,
                    'Нет' => false
                ],
                'required' => false
            ]);

    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}