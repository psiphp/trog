<?php

namespace Trog\Bundle\ResourceBrowser\Controller;

use Puli\Repository\Api\ResourceRepository;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Cmf\Bundle\ResourceBundle\Registry\RepositoryRegistry;
use Puli\Repository\Api\ResourceNotFoundException;
use Webmozart\PathUtil\Path;
use Psi\Component\ResourceBrowser\Browser;
use Trog\Bundle\ResourceBrowser\Browser\ViewRegistry;
use Psi\Component\ResourceBrowser\Filter\AcceptorRegistry;
use Psi\Component\ResourceBrowser\Filter\Filter\AcceptorFilter;

class BrowserController
{
    const SESSION_PATH = 'session.path';
    const REPOSITORY = 'session.repository';

    private $templating;
    private $registry;
    private $browserViewRegistry;
    private $session;
    private $acceptorRegistry;

    public function __construct(
        RepositoryRegistry $registry,
        EngineInterface $templating,
        Session $session,
        ViewRegistry $browserViewRegistry,
        AcceptorRegistry $acceptorRegistry
    ) {
        $this->templating = $templating;
        $this->registry = $registry;
        $this->session = $session;
        $this->browserViewRegistry = $browserViewRegistry;
        $this->acceptorRegistry = $acceptorRegistry;
    }

    public function indexAction(Request $request)
    {
        $path = $request->query->get('path') ?: null;
        $browserName = $request->get('browser');
        $browserView = $this->browserViewRegistry->get($browserName);
        $repositories = $browserView->getRepositories() ?: $allRepositories;
        $repositoryName = $this->resolveRepositoryName($request, $browserView->getDefaultRepository(), $repositories);
        $repository = $this->registry->get($repositoryName);

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

        $path = $this->resolvePath($repository, $path);

        $browser = Browser::createFromOptions($repository, [
            'path' => $path,
            'nb_columns' => $browserView->getColumns(),
            'filter' => new AcceptorFilter($this->acceptorRegistry, $browserView->getFilterConfigs()),
        ]);

        $allRepositories = $this->registry->names();
        if ($diff = array_diff($repositories, $allRepositories)) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown repositories enabled in browser view "%s": "%s"',
                $browserName, implode('", "', $diff)
            ));
        }

        if (!in_array($repositoryName, $repositories)) {
            $repositoryName = reset($repositories);
        }

        $numberFormatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
        $words = $numberFormatter->format($browser->getMaxColumns());

        return $this->templating->renderResponse(
            $browserView->getTemplate(),
            [
                'repositories' => $repositories,
                'repositoryName' => $repositoryName,
                'browser' => $browser,
                'browserName' => $browserName,
                'route' => $request->attributes->get('_route'),
                'nbColumnsInWords' => $words,
                'view' => $browserView,
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

    private function resolvePath(ResourceRepository $repository, $path)
    {
        if (!$path) {
            return '/';
        }

        try {
            $repository->get($path);

            return $path;
        } catch (ResourceNotFoundException $e) {
        }

        $path = Path::getDirectory($path);

        return $this->resolvePath($repository, $path);
    }

    private function resolveRepositoryName(Request $request, $defaultName, $availableRepositories)
    {
        $repositoryName = $request->get('repository');

        if ($repositoryName && in_array($defaultName, $availableRepositories)) {
            $this->session->set(self::REPOSITORY, $repositoryName);

            return $repositoryName;
        }

        if ($this->session->has(self::REPOSITORY)) {
            $repo = $this->session->get(self::REPOSITORY);
            if (in_array($repo, $availableRepositories)) {
                return $repo;
            }
        }

        return $defaultName;
    }
}
