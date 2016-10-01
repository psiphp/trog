<?php

namespace Trog\Bundle\Media\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class TrogMediaExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $container->setParameter('trog_media.filesystem_path', realpath(sprintf('%s/%s', $container->getParameter('kernel.root_dir'), '/../web/files')));
        $container->setParameter('trog_media.filesystem_web_path', '/files');

        $loader->load('filesystem.xml');
        $loader->load('util.xml');
        $loader->load('twig.xml');
        $loader->load('description.xml');
        $loader->load('controller.xml');
    }
}
