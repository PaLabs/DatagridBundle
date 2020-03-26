<?php


namespace PaLabs\DatagridBundle\DataSource\Doctrine\Filter\Type;


use PaLabs\DatagridBundle\DataSource\Filter\Options\BaseFilterOptions;

class EntityFilterOptions extends BaseFilterOptions
{
    public function entityForm(string $entityForm): self {
        $this->filterOptions['entity_form'] = $entityForm;
        return $this;
    }

    public function entityOptions(array $entityFormOptions): self {
        $this->filterOptions['entity_options'] = $entityFormOptions;
        return $this;
    }
}