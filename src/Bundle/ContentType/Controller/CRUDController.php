<?php

namespace Trog\Bundle\ContentType\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Trog\Component\ObjectAgent\AgentFinder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Trog\Bundle\ContentType\Form\Event\ValidFormEvent;
use Trog\Bundle\ContentType\Form\Event\PropagateValidFormEventSubscriber;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

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
    ) {
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
        $form = $this->formFactory->createBuilder($objectFqn, $object);
        $form->addEventSubscriber(new PropagateValidFormEventSubscriber());
        $form = $form->getForm();

        if ($request->getMethod() === 'POST' && $form->handleRequest($request)->isValid()) {
            $form->getConfig()->getEventDispatcher()->dispatch(
                ValidFormEvent::EVENT_NAME,
                new ValidFormEvent($form)
            );
            $agent->save($object);

            return new RedirectResponse($this->urlGenerator->generate(
                $request->attributes->get('_route'),
                [
                    'agent' => $agent->getAlias(),
                    'identifier' => $identifier,
                ]
            ));
        }

        try {
            $objectUrl = $this->urlGenerator->generate($object);
        } catch (RouteNotFoundException $e) {
            $objectUrl = null;
        }

        return new Response($this->templating->render(
            $template,
            [
                'object_url' => $objectUrl,
                'form' => $form->createView(),
            ]
        ));
    }

    public function createAsChild(Request $request)
    {
        $template = $request->attributes->get('template');
        $type = $request->attributes->get('type');
        $parentIdentifier = $request->attributes->get('parent_identifier');

        $agent = $this->agentFinder->findAgentFor($type);
        $form = $this->formFactory->createBuilder($type);

        $form->addEventSubscriber(new PropagateValidFormEventSubscriber());
        $form = $form->getForm();

        $parentObject = $agent->find($parentIdentifier);

        if ($request->getMethod() === 'POST' && $form->handleRequest($request)->isValid()) {
            $form->getConfig()->getEventDispatcher()->dispatch(
                ValidFormEvent::EVENT_NAME,
                new ValidFormEvent($form)
            );
            $agent->setParent($form->getData(), $parentObject);
            $agent->save($form->getData());
            $identifier = $agent->getIdentifier($form->getData());

            return new RedirectResponse($this->urlGenerator->generate(
                'trog_content_type_crud_edit',
                [
                    'agent' => $agent->getAlias(),
                    'identifier' => $identifier,
                ]
            ));
        }

        try {
            $objectUrl = $this->urlGenerator->generate($form->getData());
        } catch (RouteNotFoundException $e) {
            $objectUrl = null;
        }

        return new Response($this->templating->render(
            $template,
            [
                'object_url' => $objectUrl,
                'form' => $form->createView(),
            ]
        ));
    }
}
