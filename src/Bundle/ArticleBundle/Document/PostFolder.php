<?php

namespace Trog\Bundle\ArticleBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={"Trog\Bundle\ArticleBundle\Document\Post"}
 * )
 */
class PostFolder extends AbstractFolder
{
}
