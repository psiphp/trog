<?php

namespace Trog\Bundle\Media\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Trog\Bundle\Media\Form\FolderType;
use Trog\Bundle\Media\Document\Folder;

class FolderController
{
    private $templating;
    private $formFactory;
    private $documentManager;
    private $urlGenerator;

    public function __construct(
        DocumentManagerInterface $documentManager,
        EngineInterface $templating,
        FormFactoryInterface $formFactory,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->templating = $templating;
        $this->formFactory = $formFactory;
        $this->documentManager = $documentManager;
        $this->urlGenerator = $urlGenerator;
    }

    public function createFolder(Request $request)
    {
        $parentIdentifier = $request->attributes->get('parent_identifier');
        $parentObject = $this->documentManager->find(null, $parentIdentifier);

        if (!$parentObject) {
            throw new \InvalidArgumentException(sprintf(
                'Could not find parent document "%s"',
                $parentIdentifier
            ));
        }

        $folder = new Folder();
        $folder->setParent($parentObject);

        return $this->processRequest($request, $folder);
    }

    public function editFolder(Request $request)
    {
        $identifier = $request->attributes->get('identifier');
        $folder = $this->documentManager->find(Folder::class, $identifier);

        if (null === $folder) {
            throw new NotFoundHttpException(sprintf(
                'Folder "%s" not found.',
                $identifier
            ));
        }

        return $this->processRequest($request, $folder);
    }

    private function processRequest(Request $request, Folder $folder)
    {
        $form = $this->formFactory->create(FolderType::class, $folder);
        $template = $request->attributes->get('template');

        if ($request->getMethod() === 'POST' && $form->handleRequest($request)->isValid()) {
            $this->documentManager->persist($folder);
            $this->documentManager->flush();

            return new RedirectResponse($this->urlGenerator->generate(
                'trog_media_edit_folder',
                [
                    'identifier' => $folder->getId(),
                ]
            ));
        }

        return new Response($this->templating->render(
            $template,
            [
                'form' => $form->createView(),
                'folder' => $folder,
            ]
        ));
    }
}
