<?php

namespace Trog\Bundle\Media\Controller;

use Symfony\Cmf\Bundle\ResourceBundle\Registry\RepositoryRegistry;
use Symfony\Cmf\Component\Resource\Repository\Resource\CmfResource;
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
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Trog\Bundle\Media\Document\File;

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
    )
    {
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

        $form = $this->formFactory->createBuilder(FormType::class, null, [
            'data_class' => File::class
        ])
            ->add('uploadedFile', FileType::class)
            ->getForm();

        $file = new File();
        $file->setParent($parentObject);

        return $this->processRequest($request, $file, $form);
    }

    public function editFile(Request $request)
    {
        $identifier = $request->attributes->get('identifier');
        $file = $this->documentManager->find(File::class, $identifier);
        $form = $this->formFactory->createBuilder(FormType::class, null, [
            'data_class' => File::class
        ])
            ->add('uploadedFile', FileType::class)
            ->getForm();

        if (null === $file) {
            throw new \InvalidArgumentException(sprintf(
                'File "%s" not found.',
                $identifier
            ));
        }

        return $this->processRequest($request, $file, $form);
    }

    private function processRequest(Request $request, $file, $form)
    {
        $template = $request->attributes->get('template');
        if ($request->getMethod() === 'POST' && $form->handleRequest($request)->isValid()) {
            $uploadedFile = $form->get('uploadedFile')->getData();

            // FACTOR THIS OUT
            $stream = fopen($uploadedFile->getPathname(), 'r');
            $file->getContent()->setData($stream);
            $file->setName($uploadedFile->getClientOriginalName());

            if (!$file->getId()) {
                $file->setCreatedAt(new \DateTime());
                $file->setCreatedBy('anon');
            }

            $finfo = new \finfo();
            $file->getContent()->setMimeType($finfo->file($uploadedFile->getPathname(), FILEINFO_MIME_TYPE));
            $file->getContent()->setEncoding($finfo->file($uploadedFile->getPathname(), FILEINFO_MIME_ENCODING));

            $this->documentManager->persist($file);
            $this->documentManager->flush();
            // FACTOR THIS OUT

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
                'form' => $form->createView()
            ]
        ));
    }
}
