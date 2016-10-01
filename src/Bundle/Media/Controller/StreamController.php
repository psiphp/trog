<?php

namespace Trog\Bundle\Media\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamController
{
    private $documentManager;

    public function __construct(
        DocumentManagerInterface $documentManager
    )
    {
        $this->documentManager = $documentManager;
    }

    public function stream(Request $request)
    {
        $identifier = $request->attributes->get('identifier');
        $file = $this->documentManager->find(File::class, $identifier);

        if (null === $file) {
            throw new NotFoundHttpException(sprintf(
                'Could not find file with ID "%s"', $identifier
            ));
        }

        return new StreamedResponse(function () use ($document) {
            stream_copy_to_stream(
                $document->getContent()->getData(),
                fopen('php:://output', 'w')
            );
        }, 200, [ 
            'Content-Type' => $document->getContent()->getMimeType(),
        ]);
    }
}
