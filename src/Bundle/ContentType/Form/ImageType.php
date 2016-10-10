<?php

namespace Trog\Component\ContentType\Form;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\File;
use Trog\Bundle\ContentType\Form\Event\ValidFormEvent;
use Trog\Bundle\Media\Util\Uploader;

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
            $data = $event->getForm()->getData();

        });
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('data_class', File::class);
    }
}
