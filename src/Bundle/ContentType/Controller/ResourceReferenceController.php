<?php

namespace Trog\Bundle\ContentType\Controller;

use Symfony\Cmf\Bundle\ResourceBundle\Registry\RepositoryRegistry;
use Psi\Component\Description\DescriptionFactory;

class ResourceReferenceController
{
    private $repositoryRegistry;
    private $descriptionFactory;
    private $templating;

    public function __construct(
        RepositoryRegistry $repositoryRegistry,
        DescriptionFactory $descriptionFactory,
        EngineInterface $templating
    )
    {
        $this->repositoryRegistry = $repositoryRegistry;
        $this->descriptionFactory = $descriptionFactory;
        $this->templating = $templating;
    }

    public function formTypePreviewAction(Request $request)
    {
        $repositoryName = $request->get('repository');
        $path = $request->get('path');

        $repository = $this->repositoryFactory->get($repositoryName);
        $resource = $repository->get($path);

        $description = $this->descriptionFactory->describe($resource);

        $view = new Description();
        $view->set('title', new Title($description->get('std.title')));
        $view->set('image', new Image($description->get('std.image')));
        $view->set('description', new Text($description->get('std.description'));

        return new Response($this->templating->render($view));
    }
}
