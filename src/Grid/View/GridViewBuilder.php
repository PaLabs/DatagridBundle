<?php

namespace PaLabs\DatagridBundle\Grid\View;


use PaLabs\DatagridBundle\DataSource\ConfigurableDataSource;
use PaLabs\DatagridBundle\DataTable\ConfigurableDataTable;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Renderer\FieldRenderer;
use PaLabs\DatagridBundle\Grid\Form\GridForm;
use PaLabs\DatagridBundle\Grid\Form\GridFormData;
use PaLabs\DatagridBundle\Grid\GridContext;
use PaLabs\DatagridBundle\Grid\GridOptions;
use PaLabs\DatagridBundle\Grid\GridParameters;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class GridViewBuilder
{
    protected FormFactoryInterface $formFactory;
    protected FieldRenderer $fieldRenderer;

    public function __construct(
        FormFactoryInterface $formFactory,
        FieldRenderer $fieldRenderer)
    {
        $this->formFactory = $formFactory;
        $this->fieldRenderer = $fieldRenderer;
    }

    public function buildView(
        Request $request,
        ConfigurableDataTable $dataTable,
        ConfigurableDataSource $dataSource,
        GridParameters $parameters,
        GridOptions $options): GridView
    {

        $dataTableConfig = $dataTable->configure($parameters);
        $dataSourceConfig = $dataSource->configure($parameters);

        $gridFormOptions = [
            'dataTableSettings' => [
                'type' => $dataTableConfig->getForm(),
                'options' => $dataTableConfig->getFormOptions()
            ],
            'dataSourceSettings' => [
                'type' => $dataSourceConfig->getForm(),
                'options' => $dataSourceConfig->getFormOptions()
            ]
        ];

        $gridFormDefaults = (new GridFormData())
            ->setDataTableSettings($dataTableConfig->getFormDefaults())
            ->setDataSourceSettings($dataSourceConfig->getFormDefaults());
        // Clear filters if request has grid data. Need to do it because form defaults can exists, and request data must overwrite
        // all filter defaults (if user unset enabled by default filter - it must be unset)
        if(!empty($this->gridRequestData($request))) {
            $gridFormDefaults->getDataSourceSettings()->setFilters([]);
        }

        $gridForm = $this->formFactory->createNamed(GridForm::FORM_NAME, GridForm::class, $gridFormDefaults, $gridFormOptions);
        $gridData = $this->handleForm($request, $gridForm);

        $gridContext = new GridContext($gridData, $parameters, $options);

        $dataSourceResult = $dataSource->rows($dataSourceConfig, $gridContext);
        $dataTableResult = $dataTable->rows($dataSourceResult, $dataTableConfig, $gridContext);

        $headerRowsIterator = $this->rowsIterator($dataTableResult->getHeader(), $gridContext->getOptions()->getRenderFormat());
        $viewRowsIterator = $this->rowsIterator($dataTableResult->getRows(), $gridContext->getOptions()->getRenderFormat());

        return new GridView(
            $headerRowsIterator,
            $viewRowsIterator,
            $gridForm->createView(),
            $dataSourceResult,
            $gridContext
        );

    }

    private function gridRequestData(Request $request) {
        return $request->query->all(GridForm::FORM_NAME);
    }

    private function handleForm(Request $request, FormInterface $form)
    {
        $requestData = $request->query->all($form->getName());
        $form->submit($requestData, false);
        return $form->getData();
    }

    protected function rowsIterator($rows, $format): \Generator
    {
        foreach ($rows as $row) {
            yield $this->rowIterator($row, $format);
        }
    }

    protected function rowIterator($row, $format): \Generator
    {
        /** @var FieldData[] $row */
        foreach ($row as $field) {
            foreach ($this->fieldRenderer->renderField($field, $format) as $renderResult) {
                yield $renderResult;
            }
        }
    }

}