<?php

namespace Sycms\Bundle\ArticleBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={"Sycms\Bundle\ArticleBundle\Document\Post"}
 * )
 */
class PostFolder extends AbstractFolder
{
}
