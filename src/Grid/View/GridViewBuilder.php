<?php

namespace PaLabs\DatagridBundle\Grid\View;


use PaLabs\DatagridBundle\DataTable\ConfigurableDataTable;
use PaLabs\DatagridBundle\DataSource\ConfigurableDataSource;
use PaLabs\DatagridBundle\DataSource\Result\PagedDataSourceResultContainer;
use PaLabs\DatagridBundle\Field\FieldData;
use PaLabs\DatagridBundle\Field\Renderer\FieldRenderer;
use PaLabs\DatagridBundle\Grid\Form\GridForm;
use PaLabs\DatagridBundle\Grid\Form\GridFormData;
use PaLabs\DatagridBundle\Grid\GridContext;
use PaLabs\DatagridBundle\Grid\GridContextBuilder;
use PaLabs\DatagridBundle\Grid\GridOptions;
use PaLabs\DatagridBundle\Grid\GridParameters;
use PaLabs\DatagridBundle\Grid\View\ContextBuilderTrait;
use PaLabs\DatagridBundle\Grid\View\GridView;
use PaLabs\DatagridBundle\Grid\View\ViewBuilderTrait;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class GridViewBuilder
{
    protected $formFactory;
    protected $fieldRenderer;

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
        GridOptions $options)
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

        $gridForm = $this->formFactory->createNamed(GridForm::FORM_NAME, GridForm::class, $gridFormDefaults, $gridFormOptions);
        $gridData = $this->handleForm($request, $gridForm);

        $gridContext = new GridContext($gridData, $parameters, $options);
        //$gridContext->getDataSourceSettings()->setPage($request->query->get('page', 1));

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

    private function handleForm(Request $request, FormInterface $form)
    {
        $requestData = $request->query->get($form->getName());
        $form->submit($requestData, false);
        $formData = $form->getData();

        return $formData;
    }

    protected function rowsIterator($rows, $format)
    {
        foreach ($rows as $row) {
            yield $this->rowIterator($row, $format);
        }
    }

    protected function rowIterator($row, $format)
    {
        /** @var FieldData[] $row */
        foreach ($row as $field) {
            foreach ($this->fieldRenderer->renderField($field, $format) as $renderResult) {
                yield $renderResult;
            }
        }
    }

}