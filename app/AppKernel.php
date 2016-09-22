<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Trog\Bundle\Admin\TrogAdminBundle(),
            new Trog\Bundle\ResourceBrowser\TrogResourceBrowserBundle(),
            new Trog\Bundle\TextEditor\TrogTextEditorBundle(),
            new Trog\Bundle\Article\TrogArticleBundle(),
            new Trog\Bundle\ObjectAgent\TrogObjectAgentBundle(),
            new Trog\Bundle\ContentType\TrogContentTypeBundle(),
            new Trog\Bundle\Media\TrogMediaBundle(),

            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),

            new Symfony\Cmf\Bundle\ResourceBundle\CmfResourceBundle(),
            new Psi\Bundle\ContentType\PsiContentTypeBundle(),
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            new Symfony\Cmf\Bundle\RoutingAutoBundle\CmfRoutingAutoBundle(),

            new Liip\ImagineBundle\LiipImagineBundle()
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
