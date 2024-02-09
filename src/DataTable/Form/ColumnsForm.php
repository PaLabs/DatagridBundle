<?php

namespace PaLabs\DatagridBundle\DataTable\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColumnsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $allowedFieldNames = array_map(fn($field) => $field['name'], $options['fields']);

        $builder->addModelTransformer(new CallbackTransformer(
            function ($valuesAsArray) use ($allowedFieldNames) {
                $valuesAsArray = array_filter($valuesAsArray, function ($fieldName) use ($allowedFieldNames) {
                    return in_array($fieldName, $allowedFieldNames);
                });
                return implode(',', $valuesAsArray);
            },
            function ($valuesAsString) use ($allowedFieldNames) {
                $fields = explode(',', $valuesAsString);
                return array_filter($fields, function ($fieldName) use ($allowedFieldNames) {
                    return in_array($fieldName, $allowedFieldNames);
                });
            }
        ));
    }


    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $fieldLabels = [];
        foreach ($options['fields'] as $field) {
            $fieldLabels[$field['name']] = $field['label'];
        }

        $view->vars['fields'] = $this->groupFields($options['fields']);
        $view->vars['fieldLabels'] = $fieldLabels;
    }

    protected function groupFields(array $fields): array
    {
        $fieldGroups = [];

        foreach($fields as $field) {
            $fieldGroups[$field['group']][] = $field;
        }
        return $fieldGroups;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'required' => false,
            ])
            ->setRequired([
                'fields'
            ]);
    }


    public function getParent(): string
    {
        return TextType::class;
    }


}