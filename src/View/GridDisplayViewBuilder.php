<?php

namespace PaLabs\DatagridBundle\View;


use PaLabs\DatagridBundle\ConfigurableGridInterface;
use PaLabs\DatagridBundle\DataSource\ConfigurableDataSource;
use PaLabs\DatagridBundle\DataSource\Result\DataSourcePagerResult;
use PaLabs\DatagridBundle\Field\FieldRenderer;
use PaLabs\DatagridBundle\GridContext;
use PaLabs\DatagridBundle\GridContextBuilder;
use PaLabs\DatagridBundle\GridParameters;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class GridDisplayViewBuilder
{
    use ViewBuilderTrait;

    protected $contextBuilder;
    protected $fieldRenderer;

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
        GridParameters $parameters = null)
    {
        if($parameters === null) {
            $parameters = new GridParameters();
        }
        
        /** @var GridContext $gridContext */
        /** @var FormInterface $gridForm */
        list($gridContext, $gridForm, $gridConfig, $dataSourceConfig) = $this->contextBuilder->handleRequest($request, $grid, $dataSource, $parameters);
        $gridContext->dataSourceSettings->setPage($request->query->get('page', 1));
        $gridContext->pagingType = GridContext::PAGING_TYPE_SPLIT_BY_PAGES;
        $gridContext->displayFormat = GridContext::DISPLAY_FORMAT_HTML;

        /** @var DataSourcePagerResult $result */
        $result = $dataSource->rows($dataSourceConfig, $gridContext);

        $view = $grid->buildView($result->getPages(), $gridConfig, $gridContext);
        $headerRowsIterator = $this->viewRowsIterator($view['header'], $gridContext->displayFormat);
        $viewRowsIterator = $this->viewRowsIterator($view['rows'], $gridContext->displayFormat);

        return new GridView(
            $headerRowsIterator,
            $viewRowsIterator,
            $gridForm->createView(),
            $result,
            $gridContext
        );

    }
}