<?php

namespace Trog\Bundle\Article\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={"Trog\Bundle\Article\Document\Page", "Trog\Bundle\Article\Document\Example"}
 * )
 */
class PageFolder extends AbstractFolder
{
}
