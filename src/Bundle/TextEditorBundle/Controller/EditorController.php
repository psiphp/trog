<?php

namespace Sycms\Bundle\TextEditorBundle\Controller;

use Symfony\Cmf\Component\Resource\RepositoryRegistryInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Puli\Repository\Resource\FileResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EditorController
{
    private $registry;
    private $templating;
    private $urlGenerator;

    public function __construct(
        RepositoryRegistryInterface $registry,
        EngineInterface $templating,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->registry = $registry;
        $this->templating = $templating;
        $this->urlGenerator = $urlGenerator;
    }

    public function edit(Request $request)
    {
        $repositoryName = $request->attributes->get('repository') ?: 'default';
        $template = $request->attributes->get('template') ?: '@SycmsTextEditor/index.html.twig';
        $path = $request->query->get('path') ?: '/';

        $repository = $this->registry->get($repositoryName);
        $resource = $repository->get($path);

        if ($request->getMethod() === 'POST') {
            file_put_contents($resource->getFilesystemPath(), $request->request->get('text'));
            return new RedirectResponse(
                $this->urlGenerator->generate('sycms_text_editor', [
                    'repository' => $repositoryName,
                    'path' => $path
                ])
            );
        }

        if (!$resource instanceof FileResource) {
            throw new \InvalidArgumentException(sprintf(
                'The text editor can only edit FileResource instances, got "%s"',
                get_class($resource)
            ));
        }

        return new Response($this->templating->render(
            $template,
            [
                'resource' => $resource,
                'repositoryName' => $repositoryName,
            ]
        ));

    }
}
