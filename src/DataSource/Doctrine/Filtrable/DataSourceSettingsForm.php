<?php

namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filtrable;


use PaLabs\DatagridBundle\DataSource\DataSourceSettings;
use PaLabs\DatagridBundle\Filter\FilterForm;
use PaLabs\DatagridBundle\Filter\GridFilterForm;
use PaLabs\DatagridBundle\Sort\GridOrderForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DataSourceSettingsForm extends AbstractType
{
    const FILTERS_FORM_NAME = 'f';
    const ORDER_FORM_NAME = 'o';
    const PER_PAGE_FORM_NAME = 'pp';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::FILTERS_FORM_NAME, GridFilterForm::class, [
                'property_path' => 'filters',
                'filters' => $options['filters']
            ])
            ->add(self::ORDER_FORM_NAME, GridOrderForm::class, [
                'property_path' => 'order',
                'entry_options' => ['sortFields' => $this->makeSortFields($options['sorting'])]
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
            $sortFields[$options['label']] = $name;
        }
        return $sortFields;
    }

    public static function urlParameters(array $filters = [], array $order = [], $perPage = null)
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
        return FilterForm::class;
    }


}