<?php

namespace Trog\Bundle\Article\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Psi\Component\ContentType\Metadata\Annotations as ContentType;
use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Trog\Bundle\ContentType\Document\PublishPeriod;

/**
 * @PHPCR\Document(
 *     referenceable=true,
 *     childClasses={
 *         "Trog\Bundle\Article\Document\Page",
 *     }
 * )
 */
class Example implements RouteReferrersReadInterface
{
    /**
     * @PHPCR\Nodename()
     */
    public $name;

    /**
     * @PHPCR\Id()
     */
    public $path;

    /**
     * @PHPCR\ParentDocument()
     */
    public $parent;

    /**
     * @PHPCR\Uuid()
     */
    public $uuid;

    /**
     * @PHPCR\Referrers(
     *     referringDocument="Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route",
     *     referencedBy="content"
     * )
     */
    public $routes;

    /**
     * @ContentType\Field(group="main", type="text")
     */
    public $title;

    /**
     * @ContentType\Field(group="main", type="birthday")
     */
    public $birthday;

    /**
     * @ContentType\Field(group="main", type="checkbox")
     */
    public $checkbox;

    /**
     * @ContentType\Field(group="main", type="collection", shared={
     *     "field_type": "birthday",
     * })
     */
    public $collection;

    /**
     * @ContentType\Field(group="main", type="country")
     */
    public $country;

    /**
     * @ContentType\Field(group="main", type="currency")
     */
    public $currency;

    /**
     * @ContentType\Field(group="main", type="date")
     */
    public $date;

    /**
     * @ContentType\Field(group="main", type="datetime")
     */
    public $dateTime;

    /**
     * @ContentType\Field(group="main", type="email")
     */
    public $email;

    /**
     * @ContentType\Field(group="main", type="integer")
     */
    public $integer;

    /**
     * @ContentType\Field(group="main", type="language")
     */
    public $language;

    /**
     * @ContentType\Field(group="main", type="locale")
     */
    public $locale;

    /**
     * @ContentType\Field(group="main", type="money")
     */
    public $money;

    /**
     * @ContentType\Field(group="main", type="number")
     */
    public $number;

    /**
     * @ContentType\Field(group="main", type="percent")
     */
    public $percent;

    /**
     * @ContentType\Field(group="main", type="range")
     */
    public $range;

    /**
     * @ContentType\Field(group="main", type="textarea")
     */
    public $textarea;

    /**
     * @ContentType\Field(group="main", type="time")
     */
    public $time;

    /**
     * @ContentType\Field(group="main", type="timezone")
     */
    public $timezone;

    /**
     * @ContentType\Field(group="main", type="url")
     */
    public $url;

    public function getTitle() 
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        $this->name = $title;
    }
    

    public function getRoutes()
    {
        return $this->routes;
    }
}
