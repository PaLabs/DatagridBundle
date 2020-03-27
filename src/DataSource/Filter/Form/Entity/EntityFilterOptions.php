<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form\Entity;


use PaLabs\DatagridBundle\DataSource\Filter\Options\BaseFilterOptions;

class EntityFilterOptions extends BaseFilterOptions
{
    public function entityForm(string $entityForm) {
        $this->formOptions['entity_form'] = $entityForm;
        return $this;
    }

    public function entityOptions(array $entityFormOptions) {
        $this->formOptions['entity_options'] = $entityFormOptions;
        return $this;
    }
}