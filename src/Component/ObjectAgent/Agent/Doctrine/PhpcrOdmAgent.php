<?php

namespace Trog\Component\ObjectAgent\Agent\Doctrine;

use Trog\Component\ObjectAgent\AgentInterface;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Doctrine\Common\Util\ClassUtils;

class PhpcrOdmAgent implements AgentInterface
{
    private $documentManager;
    private $alias;

    public function __construct($alias, DocumentManagerInterface $documentManager)
    {
        $this->alias = $alias;
        $this->documentManager = $documentManager;
    }

    /**
     * {@inheritDoc}
     */
    public function save($object)
    {
        $this->documentManager->persist($object);
        $this->documentManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function find($identifier)
    {
        $object = $this->documentManager->find(null, $identifier);

        if (null === $object) {
            throw new ObjectNotFound($identifier);
        }

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier($object)
    {
        $objectFqn = ClassUtils::getRealClass(get_class($object));
        $metadata = $this->documentManager->getClassMetadata($objectFqn);
        $uuidFieldName = $metadata->getUuidFieldName();

        if (!$uuidFieldName) {
            throw new \RuntimeException(sprintf(
                'Document "%s" does not have a UUID-mapped property. All '.
                'PHPCR-ODM documents must have a mapped UUID proprety.',
                $objectFqn
            ));
        }

        $node = $this->documentManager->getNodeForDocument($object);

        return $node->getIdentifier();
    }

    /**
     * {@inheritdoc}
     */
    public function setParent($object, $parent)
    {
        $objectFqn = ClassUtils::getRealClass(get_class($object));
        $metadata = $this->documentManager->getClassMetadata($objectFqn);
        $parentField = $metadata->parentMapping;

        if (!$parentField) {
            throw new \RuntimeException(sprintf(
                'Document "%s" does not have a ParentDocument mapping All '.
                'PHPCR-ODM documents must have a mapped parent proprety.',
                $objectFqn
            ));
        }

        $metadata->setFieldValue($object, $parentField, $parent);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * {@inheritDoc}
     */
    public function supports($class)
    {
        $metadataFactory = $this->documentManager->getMetadataFactory();
        $supports =  $metadataFactory->getMetadataFor(ClassUtils::getRealClass($class));

        return $supports ? true : false;
    }
}
