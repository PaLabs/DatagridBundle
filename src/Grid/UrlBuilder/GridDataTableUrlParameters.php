<?php


namespace PaLabs\DatagridBundle\Grid\UrlBuilder;


use PaLabs\DatagridBundle\DataTable\Form\SettingsForm;

class GridDataTableUrlParameters
{
    protected $fields = [];
    
    public function build(): array {
        if(empty($this->fields)) {
            return [];
        }
        
        return [
            SettingsForm::FIELDS_FORM_NAME => implode(',', $this->fields)
        ];
    }
    
    public function addField(string $field): self {
        $this->fields[] = $field;
        return $this;
    }

    public function addFields(array $fields): self {
        foreach($fields as $field) {
            $this->fields[] = $field;
        }
        return $this;
    }
}