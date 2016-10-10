<?php

namespace Trog\Bundle\Media\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType as BaseFileType;
use Trog\Bundle\ContentType\Form\Event\ValidFormEvent;
use Trog\Bundle\Media\Document\File;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('uploadedFile', BaseFileType::class, [
            'constraints' => $options['file_constraints'],
        ]);

        $builder->addEventListener(ValidFormEvent::EVENT_NAME, function (ValidFormEvent $event) {
            $data = $event->getForm()->getData();
            $data->consumeUploadedFile();
        });
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('data_class', File::class);
        $options->setDefault('file_constraints', []);
    }

    public function getBlockPrefix()
    {
        return 'trog_media_file';
    }
}
