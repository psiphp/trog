<?php

namespace Sycms\Bundle\ContentTypeBundle\Controller;

use Symfony\Cmf\Bundle\ResourceBundle\Registry\RepositoryRegistry;
use Symfony\Cmf\Component\Resource\Repository\Resource\CmfResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Sycms\Component\ObjectAgent\AgentFinder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CRUDController
{
    private $templating;
    private $formFactory;
    private $agentFinder;
    private $urlGenerator;

    public function __construct(
        AgentFinder $agentFinder,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->agentFinder = $agentFinder;
        $this->urlGenerator = $urlGenerator;
    }

    public function edit(Request $request)
    {
        $template = $request->attributes->get('template');
        $agent = $request->attributes->get('agent');
        $identifier = $request->attributes->get('identifier');

        $agent = $this->agentFinder->getAgent($agent);
        $object = $agent->find($identifier);
        $objectFqn = get_class($object);
        $form = $this->formFactory->create($objectFqn, $object);

        if ($request->getMethod() === 'POST' && $form->handleRequest($request)->isValid()) {
            $agent->save($object);

            return new RedirectResponse($this->urlGenerator->generate(
                $request->attributes->get('_route'),
                [
                    'agent' => $agent->getAlias(),
                    'identifier' => $identifier,
                ]
            ));
        }

        return new Response($this->templating->render(
            $template,
            [
                'form' => $form->createView()
            ]
        ));
    }

    public function createAsChild(Request $request)
    {
        $template = $request->attributes->get('template');
        $type = $request->attributes->get('type');
        $parentIdentifier = $request->attributes->get('parent_identifier');

        $agent = $this->agentFinder->findAgentFor($type);
        $form = $this->formFactory->create($type);
        $parentObject = $agent->find($parentIdentifier);

        if ($request->getMethod() === 'POST' && $form->handleRequest($request)->isValid()) {
            $agent->setParent($form->getData(), $parentObject);
            $agent->save($form->getData());
            $identifier = $agent->getIdentifier($form->getData());

            return new RedirectResponse($this->urlGenerator->generate(
                'sycms_content_type_crud_edit',
                [
                    'agent' => $agent->getAlias(),
                    'identifier' => $identifier,
                ]
            ));
        }

        return new Response($this->templating->render(
            $template,
            [
                'form' => $form->createView()
            ]
        ));
    }
}
