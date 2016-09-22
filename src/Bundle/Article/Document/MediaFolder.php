<?php

namespace Trog\Bundle\Article\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={
 *         "Trog\Bundle\Article\Document\MediaFolder",
 *         "Trog\Bundle\Article\Document\Image"
 *     }
 * )
 */
class MediaFolder extends AbstractFolder
{
}
