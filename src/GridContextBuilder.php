<?php

namespace PaLabs\DatagridBundle;


use PaLabs\DatagridBundle\DataSource\ConfigurableDataSource;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class GridContextBuilder
{
    private $formFactory;

    public function __construct(
        FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function handleRequest(
        Request $request,
        ConfigurableGridInterface $grid,
        ConfigurableDataSource $dataSource,
        GridParameters $parameters)
    {

        $gridConfig = $grid->configure($parameters);
        $dataSourceConfig = $dataSource->configure($parameters);

        $gridFormOptions = [
            'gridSettings' => [
                'type' => $gridConfig->getForm(),
                'options' => $gridConfig->getFormOptions()
            ],
            'dataSourceSettings' => [
                'type' => $dataSourceConfig->getForm(),
                'options' => $dataSourceConfig->getFormOptions()
            ]
        ];
        $gridFormDefaults = (new GridFormData())
            ->setGridSettings($gridConfig->getFormDefaults())
            ->setDataSourceSettings($dataSourceConfig->getFormDefaults());

        $gridForm = $this->formFactory->createNamed(GridForm::FORM_NAME, GridForm::class, $gridFormDefaults, $gridFormOptions);
        $gridData = $this->handleForm($request, $gridForm);

        $gridContext = new GridContext($gridData, $parameters);
        return [$gridContext, $gridForm, $gridConfig, $dataSourceConfig];
    }

    private function handleForm(Request $request, FormInterface $form)
    {
        $requestData = $request->query->get($form->getName());
        $form->submit($requestData, false);
        $formData = $form->getData();

        return $formData;
    }
}