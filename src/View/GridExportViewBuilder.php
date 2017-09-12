<?php

namespace PaLabs\DatagridBundle\View;


use PaLabs\DatagridBundle\ConfigurableGridInterface;
use PaLabs\DatagridBundle\DataSource\ConfigurableDataSource;
use PaLabs\DatagridBundle\DataSource\Result\DataSourceResult;
use PaLabs\DatagridBundle\Field\FieldRenderer;
use PaLabs\DatagridBundle\GridContext;
use PaLabs\DatagridBundle\GridContextBuilder;
use PaLabs\DatagridBundle\GridParameters;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class GridExportViewBuilder
{
    use ViewBuilderTrait;
    private $contextBuilder;

    public function __construct(
        GridContextBuilder $contextBuilder,
        FieldRenderer $fieldRenderer)
    {
        $this->contextBuilder = $contextBuilder;
        $this->fieldRenderer = $fieldRenderer;
    }

    public function buildView(
        Request $request,
        ConfigurableGridInterface $grid,
        ConfigurableDataSource $dataSource,
        GridParameters $parameters,
        string $displayFormat)
    {
        /** @var GridContext $gridContext */
        /** @var FormInterface $gridForm */
        list($gridContext, $gridForm, $gridConfig, $dataSourceConfig) = $this->contextBuilder->handleRequest($request, $grid, $dataSource, $parameters);

        $gridContext->dataSourceSettings->setPage($request->query->get('page', 1));
        $gridContext->pagingType = GridContext::PAGING_TYPE_SINGLE_PAGE;
        $gridContext->displayFormat = $displayFormat;

        /** @var DataSourceResult $result */
        $result = $dataSource->rows($dataSourceConfig, $gridContext);

        $view = $grid->buildView($result->getPages(), $gridConfig, $gridContext);
        $headerRowsIterator = $this->viewRowsIterator($view['header'], $gridContext->displayFormat);
        $viewRowsIterator = $this->viewRowsIterator($view['rows'], $gridContext->displayFormat);

        return [
            'form' => $gridForm->createView(),
            'header' => $headerRowsIterator,
            'rows' => $viewRowsIterator,
        ];
    }
}