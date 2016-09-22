<?php

namespace Trog\Bundle\ArticleBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={
 *         "Trog\Bundle\ArticleBundle\Document\MediaFolder",
 *         "Trog\Bundle\ArticleBundle\Document\Image"
 *     }
 * )
 */
class MediaFolder extends AbstractFolder
{
}
