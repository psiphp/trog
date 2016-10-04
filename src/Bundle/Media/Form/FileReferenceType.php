<?php

namespace Trog\Bundle\Media\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType as BaseFileType;
use Trog\Bundle\ContentType\Form\Event\ValidFormEvent;
use Symfony\Component\Validator\Constraints\File as FileConstraint;
use Trog\Bundle\Media\Document\File;
use Symfony\Component\Form\CallbackTransformer;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FileReferenceType extends AbstractType
{
    private $documentManager;

    public function __construct(DocumentManagerInterface $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CallbackTransformer(function ($value) {
            if (null === $value) {
                return;
            }

            if (!is_object($value)) {
                throw new \InvalidArgumentException(sprintf(
                    'Transformer expected an object but got a "%s"',
                    gettype($value)
                ));
            }

            return $this->documentManagre->getNodeForDocument($value)->getIdentifier();
        }, function ($value) {
            $document = $this->documentManager->find(null, $value);

            if (null === $document) {
                throw new TransformationFailedException(sprintf(
                    'Could not find document for ID "%s"',
                    $value
                ));
            }
            return $document;
        }));
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('browser', 'default');
        $options->setDefault('agent', 'default');
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['browser'] = $options['browser'];
        $view->vars['agent'] = $options['agent'];
    }

    public function getParent()
    {
        return HiddenType::class;
    }

    public function getBlockPrefix()
    {
        return 'trog_media_file_reference';
    }
}

