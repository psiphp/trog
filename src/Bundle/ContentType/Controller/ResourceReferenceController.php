<?php

namespace Trog\Bundle\ContentType\Controller;

use Symfony\Cmf\Bundle\ResourceBundle\Registry\RepositoryRegistry;
use Psi\Component\Description\DescriptionFactory;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Psi\Component\Description\Subject;
use Symfony\Component\HttpFoundation\Response;

class ResourceReferenceController
{
    private $repositoryRegistry;
    private $descriptionFactory;
    private $templating;

    public function __construct(
        RepositoryRegistry $repositoryRegistry,
        DescriptionFactory $descriptionFactory,
        EngineInterface $templating
    ) {
        $this->repositoryRegistry = $repositoryRegistry;
        $this->descriptionFactory = $descriptionFactory;
        $this->templating = $templating;
    }

    public function formTypePreviewAction(Request $request)
    {
        $repositoryName = $request->get('repository');
        $path = $request->get('path');

        $repository = $this->repositoryRegistry->get($repositoryName);
        $resource = $repository->get($path);

        $description = $this->descriptionFactory->describe(Subject::createFromObject($resource));

        return new Response($this->templating->render(
            '@TrogContentType/ResourceReference/preview.html.twig',
            [
                'repository' => $repositoryName,
                'path' => $path,
                'description' => $description,
            ]
        ));
    }
}
