<?php

namespace AppBundle\DataFixtures\PHPCR;

use AppBundle\Document\PageFolder;
use AppBundle\Document\PostFolder;
use Doctrine\ODM\PHPCR\Document\Generic;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Document\Post;

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

        $posts = new PostFolder();
        $posts->setParent($base);
        $posts->setName('posts');

        $pages = new PageFolder();
        $pages->setParent($base);
        $pages->setName('pages');

        $manager->persist($base);
        $manager->persist($posts);
        $manager->persist($pages);

        $this->loadPosts($manager, $posts);

        $manager->flush();
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
