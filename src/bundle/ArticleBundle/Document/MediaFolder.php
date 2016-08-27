<?php

namespace Sycms\Bundle\ArticleBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={
 *         "Sycms\Bundle\ArticleBundle\Document\MediaFolder",
 *         "Sycms\Bundle\ArticleBundle\Document\Image"
 *     }
 * )
 */
class MediaFolder extends AbstractFolder
{
}
