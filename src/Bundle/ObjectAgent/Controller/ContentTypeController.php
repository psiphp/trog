<?php

namespace Trog\Bundle\ObjectAgent\Controller;

use Psi\Component\Description\DescriptionFactory;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Psi\Component\Description\Subject;
use Symfony\Component\HttpFoundation\Response;
use Psi\Component\ObjectAgent\AgentFinder;

class ContentTypeController
{
    private $agentFinder;
    private $descriptionFactory;
    private $templating;

    public function __construct(
        AgentFinder $agentFinder,
        DescriptionFactory $descriptionFactory,
        EngineInterface $templating
    ) {
        $this->agentFinder = $agentFinder;
        $this->descriptionFactory = $descriptionFactory;
        $this->templating = $templating;
    }

    public function formTypePreviewAction(Request $request)
    {
        $class = $request->attributes->get('class');
        $identifier = $request->attributes->get('identifier');
        $showProperties = $request->attributes->get('show_properties');

        $agent = $this->agentFinder->findAgentFor($class);
        $object = $agent->find($identifier);
        $description = $this->descriptionFactory->describe(Subject::createFromObject($object));

        return new Response($this->templating->render(
            $showProperties
            ? '@TrogObjectAgent/ContentType/object_preview.html.twig'
            : '@TrogObjectAgent/ContentType/object_preview_thumb.html.twig',
            [
                'description' => $description,
            ]
        ));
    }
}
