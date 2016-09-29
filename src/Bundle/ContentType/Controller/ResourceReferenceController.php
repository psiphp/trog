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

        return new Response($this->templating->render(
            '@TrogContentType/ResourceReference/preview.html.twig',
            [
                'description' => $description
            ]
        ));
    }
}
