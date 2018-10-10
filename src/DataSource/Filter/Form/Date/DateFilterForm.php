<?php

namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Date;


use PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type\DateFilter;
use PaLabs\DatagridBundle\DataSource\Filter\BaseFilterForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateFilterForm extends AbstractType
{
    const PERIOD_FIELD = 'o';
    const START_FIELD = 's';
    const END_FIELD = 'e';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::PERIOD_FIELD, ChoiceType::class, [
                'choices' => [
                    'operator_interval' => DateFilter::OPERATOR_INTERVAL,
                    'operator_current_day' => DateFilter::OPERATOR_CURRENT_DAY,
                    'operator_current_year' => DateFilter::OPERATOR_CURRENT_YEAR
                ]
            ])
            ->add(self::START_FIELD, $options['dateForm'], $options['dateFormOptions'])
            ->add(self::END_FIELD, $options['dateForm'], $options['dateFormOptions']);

        $builder->addModelTransformer(new DateFilterModelTransformer());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'dateForm' => $this->dateForm(),
                'dateFormOptions' => $this->dateFormOptions(),
            ]);
    }


    protected function dateForm()
    {
        return DateType::class;
    }

    protected function dateFormOptions()
    {
        return [
            'widget' => 'single_text',
            'required' => false
        ];
    }

    public function getParent()
    {
        return BaseFilterForm::class;
    }


}