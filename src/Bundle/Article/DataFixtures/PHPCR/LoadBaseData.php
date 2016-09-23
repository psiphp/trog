<?php

namespace Trog\Bundle\Article\DataFixtures\PHPCR;

use Trog\Bundle\Article\Document\PageFolder;
use Trog\Bundle\Article\Document\PostFolder;
use Doctrine\ODM\PHPCR\Document\Generic;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Trog\Bundle\Article\Document\Post;
use Trog\Bundle\Article\Document\Page;
use Trog\Bundle\Article\Document\MediaFolder;

class LoadBaseData implements FixtureInterface
{
    /**
     * @param DocumentManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $base = $manager->find(null, '/trog');

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
