<?php

namespace Trog\Bundle\ContentType\Description;

use Symfony\Cmf\Component\Resource\Description\DescriptionEnhancerInterface;
use Psi\Component\Description\DescriptionInterface;
use Psi\Component\Description\Subject;

class ImageEnhancer extends DescriptionEnhancerInterface
{
    /**
     * {@inheritdoc}
     */
    public function enhanceFromClass(DescriptionInterface $description, \ReflectionClass $class)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function enhanceFromObject(DescriptionInterface $description, Subject $subject)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Subject $subject)
    {
        if ($subject->
    }
}
