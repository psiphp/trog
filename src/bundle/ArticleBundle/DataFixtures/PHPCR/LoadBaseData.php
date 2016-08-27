<?php

namespace Sycms\Bundle\ArticleBundle\DataFixtures\PHPCR;

use Sycms\Bundle\ArticleBundle\Document\PageFolder;
use Sycms\Bundle\ArticleBundle\Document\PostFolder;
use Doctrine\ODM\PHPCR\Document\Generic;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sycms\Bundle\ArticleBundle\Document\Post;
use Sycms\Bundle\ArticleBundle\Document\Page;
use Sycms\Bundle\ArticleBundle\Document\MediaFolder;

class LoadBaseData implements FixtureInterface
{
    /**
     * @param DocumentManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $base = new Generic();
        $base->setNodename('sycms');
        $base->setParentDocument($manager->find(null, '/'));

        $media = new MediaFolder();
        $media->setParent($base);
        $media->setTitle('media');

        $posts = new PostFolder();
        $posts->setParent($base);
        $posts->setTitle('posts');

        $pages = new PageFolder();
        $pages->setParent($base);
        $pages->setTitle('pages');

        $this->createPage($manager, $pages, 'About Us');

        $regions = $this->createPage($manager, $pages, 'Regions');
        $dorset = $this->createPage($manager, $regions, 'Dorset');
        $towns = $this->createPage($manager, $dorset, 'Towns');
        $this->createPage($manager, $towns, 'Weymouth');
        $this->createPage($manager, $towns, 'Bridport');
        $this->createPage($manager, $towns, 'Yeovil');
        $this->createPage($manager, $dorset, 'Things to do');
        $this->createPage($manager, $dorset, 'Useful links');
        $this->createPage($manager, $regions, 'Cornwall');
        $this->createPage($manager, $regions, 'Wales');
        $this->createPage($manager, $regions, 'Bristol');
        $this->createPage($manager, $pages, 'Contact');

        $manager->persist($base);
        $manager->persist($media);
        $manager->persist($posts);
        $manager->persist($pages);

        $this->loadPosts($manager, $posts);

        $manager->flush();
    }

    private function createPage($manager, $parent, $title)
    {
        $page = new Page();
        $page->setTitle($title);
        $page->setParent($parent);
        $manager->persist($page);

        return $page;
    }

    private function loadPosts(ObjectManager $manager, $parent)
    {
        $post = new Post();
        $post->setParent($parent);
        $post->setTitle('The strange case of the dog in the nighttime');
        $post->setContent('It little profits that an idle king, by this still hearth .. ');
        $manager->persist($post);
    }
}
