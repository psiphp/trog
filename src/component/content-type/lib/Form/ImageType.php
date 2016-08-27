<?php

namespace Sycms\Component\ContentType\Form;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sycms\Component\ContentType\Model\Image;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Sycms\Bundle\ContentTypeBundle\Form\Event\ValidFormEvent;
use Sycms\Bundle\MediaBundle\Util\Uploader;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;

class ImageType extends AbstractType
{
    private $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('uploadedFile', FileType::class);

        $builder->addEventListener(ValidFormEvent::EVENT_NAME, function (ValidFormEvent $event) {
            $form = $event->getForm();
            $file = $form->get('uploadedFile')->getData();

            if (null === $file) {
                return;
            }

            $object = $form->getData();
            $object->setOriginalFilename($file->getClientOriginalName());

            $mimeTypeGuesser = MimeTypeGuesser::getInstance();
            $object->setMimeType($mimeTypeGuesser->guess($file->getPathname()));
            $object->setImage($this->uploader->upload($file));
        });

        $builder->get('uploadedFile')->addModelTransformer(new CallbackTransformer(
            function ($value) {
                if (!$value) {
                    return null;
                }

                return new File($value, false);
            }, 
            function ($value) {
                return $value;
            }
        ));
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('data_class', Image::class);
    }
}
