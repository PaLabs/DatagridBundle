<?php

namespace PaLabs\DatagridBundle\DataSource;


use PaLabs\DatagridBundle\DataSource\Filter\FilterCollectionForm;
use PaLabs\DatagridBundle\DataSource\Order\OrderForm;
use PaLabs\DatagridBundle\Form\Type\EmptyGetForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DataSourceSettingsForm extends AbstractType
{
    const FILTERS_FORM_NAME = 'f';
    const ORDER_FORM_NAME = 'o';
    const PAGE_FORM_NAME = 'p';
    const PER_PAGE_FORM_NAME = 'pp';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (count($options['filters']) > 0) {
            $builder
                ->add(self::FILTERS_FORM_NAME, FilterCollectionForm::class, [
                    'property_path' => 'filters',
                    'filters' => $options['filters']
                ]);
        }
        if (count($options['sorting']) > 0) {
            $builder->add(self::ORDER_FORM_NAME, OrderForm::class, [
                'property_path' => 'order',
                'entry_options' => ['sortFields' => $this->makeSortFields($options['sorting'])]
            ]);
        }

        $builder->add(self::PAGE_FORM_NAME, IntegerType::class, [
            'property_path' => 'page'
        ]);

        if ($options['enablePerPageSelector']) {
            $builder->add(self::PER_PAGE_FORM_NAME, ChoiceType::class, [
                'property_path' => 'perPage',
                'required' => true,
                'choices' => $this->perPageChoices($options['recordsPerPage'])
            ]);
        }
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => DataSourceSettings::class,
                'recordsPerPage' => [10, 20, 50, 100],
                'enablePerPageSelector' => true
            ])
            ->setRequired([
                'filters',
                'sorting'
            ]);
    }

    private function makeSortFields(array $sorting)
    {
        $sortFields = [];
        foreach ($sorting as $name => $options) {
            if(empty($options['group'])) {
                $sortFields[$options['label']] = $name;
            } else {
                $sortFields[$options['group']][$options['label']] = $name;
            }

        }
        return $sortFields;
    }

    public static function urlParameters(array $filters = [], array $order = [], $perPage = null, $page = null)
    {
        $parameters = [];
        if (!empty($filters)) {
            $parameters[self::FILTERS_FORM_NAME] = $filters;
        }
        if (!empty($order)) {
            $parameters[self::ORDER_FORM_NAME] = $order;
        }
        if ($perPage !== null) {
            $parameters[self::PER_PAGE_FORM_NAME] = $perPage;
        }
        if($page !== null) {
            $parameters[self::PAGE_FORM_NAME] = $page;
        }

        return $parameters;
    }


    private function perPageChoices(array $recordsPerPage)
    {
        $result = [];
        foreach ($recordsPerPage as $value) {
            $result[$value] = $value;
        }
        return $result;
    }

    public function getParent()
    {
        return EmptyGetForm::class;
    }


}