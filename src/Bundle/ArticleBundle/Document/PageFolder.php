<?php

namespace Trog\Bundle\ArticleBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={"Trog\Bundle\ArticleBundle\Document\Page"}
 * )
 */
class PageFolder extends AbstractFolder
{
}
