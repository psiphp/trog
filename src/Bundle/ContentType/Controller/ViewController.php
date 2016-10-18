<?php

namespace Trog\Bundle\ContentType\Controller;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Psi\Component\ContentType\View\ViewFactory;
use Psi\Component\ContentType\Standard\View\ObjectType;

class ViewController
{
    private $templating;
    private $viewFactory;

    public function __construct(
        EngineInterface $templating,
        ViewFactory $viewFactory
    )
    {
        $this->templating = $templating;
        $this->viewFactory = $viewFactory;
    }

    public function defaultAction(Request $request)
    {
        $content = $request->attributes->get('contentDocument');
        $view = $this->viewFactory->create(ObjectType::class, $content, []);


        return new Response(
            $this->templating->render(
                '@TrogContentType/ContentType/default.html.twig', [
                    'view' => $view,
                    'content' => $content,
                ]
            )
        );
    }
}
