<?php

namespace Sycms\Bundle\ColumnBrowserBundle\Controller;

use Puli\Repository\Api\ResourceRepository;
use Symfony\Component\Templating\EngineInterface;
use Sycms\Bundle\ResourceBundle\Registry\ContainerRepositoryRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sycms\Bundle\ColumnBrowserBundle\Column\ColumnBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Cmf\Bundle\ResourceBundle\Registry\RepositoryRegistry;
use Sycms\Bundle\ColumnBrowserBundle\Column\Browser;

class BrowserController
{
    const SESSION_PATH = 'session.path';

    private $templating;
    private $registry;
    private $session; 

    public function __construct(
        RepositoryRegistry $registry,
        EngineInterface $templating,
        Session $session
    )
    {
        $this->templating = $templating;
        $this->registry = $registry;
        $this->session = $session;
    }

    public function indexAction(Request $request)
    {
        $repositoryName = $request->get('repository') ?: 'default';
        $repository = $this->registry->get($repositoryName);
        $path = $request->query->get('path') ?: null;
        $template = $request->get('template', '@SycmsColumnBrowser/index.html.twig');

        // resolve the repository name (it may have been determined automatically)
        $repositoryName = $this->registry->getRepositoryAlias($repository);

        if ($this->session->has(self::SESSION_PATH)) {
            $paths = $this->session->get(self::SESSION_PATH);
        }

        if (null === $path && isset($paths[$repositoryName])) {
            $path = $paths[$repositoryName];
        }

        if (null !== $path) {
            $paths[$repositoryName] = $path;
            $this->session->set(self::SESSION_PATH, $paths);
        }

        $path = $path ?: '/';

        $browser = new Browser($repository, $path);
        $repositories = $this->registry->names();

        return $this->templating->renderResponse(
            $template,
            [
                'repositories' => $repositories,
                'repositoryName' => $repositoryName,
                'browser' => $browser,
                'route' => $request->attributes->get('_route'),
            ],
            new Response()
        );
    }

    public function updateAction(Request $request)
    {
        $repositoryName = $request->get('repository', null);
        $operations = $request->request->get('operations', []);
        $repository = $this->registry->get($repositoryName);

        foreach ($operations as $operation) {
            switch ($operation['type']) {
                case 'reorder':
                    $repository->reorder($operation['path'], (int) $operation['position']);
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf(
                        'Invalid operation "%s"', $operation
                    ));
            }
        }

        return new JsonResponse($request->request->all());
    }
}
