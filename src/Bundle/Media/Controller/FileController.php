<?php

namespace Trog\Bundle\Media\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Trog\Bundle\Media\Document\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Trog\Bundle\Media\Form\FileType;

class FileController
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

    public function createFile(Request $request)
    {
        $parentIdentifier = $request->attributes->get('parent_identifier');
        $parentObject = $this->documentManager->find(null, $parentIdentifier);

        if (!$parentObject) {
            throw new \InvalidArgumentException(sprintf(
                'Could not find parent document "%s"',
                $parentIdentifier
            ));
        }

        $file = new File();
        $file->setParent($parentObject);

        return $this->processRequest($request, $file);
    }

    public function editFile(Request $request)
    {
        $identifier = $request->attributes->get('identifier');
        $file = $this->documentManager->find(File::class, $identifier);

        if (null === $file) {
            throw new NotFoundHttpException(sprintf(
                'File "%s" not found.',
                $identifier
            ));
        }

        return $this->processRequest($request, $file);
    }

    private function processRequest(Request $request, $file)
    {
        $form = $this->formFactory->create(FileType::class, $file);
        $template = $request->attributes->get('template');

        if ($request->getMethod() === 'POST' && $form->handleRequest($request)->isValid()) {
            $file->consumeUploadedFile();
            $file->setName($file->getUploadedFile()->getClientOriginalName());
            $this->documentManager->persist($file);
            $this->documentManager->flush();

            return new RedirectResponse($this->urlGenerator->generate(
                'trog_media_edit_file',
                [
                    'identifier' => $file->getId(),
                ]
            ));
        }

        return new Response($this->templating->render(
            $template,
            [
                'form' => $form->createView(),
                'file' => $file,
            ]
        ));
    }
}
