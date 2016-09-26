<?php

declare(strict_types=1);

namespace Trog\Bundle\ResourceBrowser\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Trog\Bundle\ResourceBrowser\Browser\View;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class TrogResourceBrowserExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $this->loadBrowserViews($config['browsers'], $container);
    }

    private function loadBrowserViews(array $config, ContainerBuilder $container)
    {
        $registryDef = $container->getDefinition('trog_resource_browser.view_registry');
        foreach ($config as $browserName => $browserView) {
            $viewDef = new Definition(
                View::class,
                [
                    $browserView['template'],
                    $browserView['repositories'],
                    $browserView['enable_move'],
                    $browserView['enable_item_actions'],
                    $browserView['columns'],
                    $browserView['default_repository']
                ]
            );
            $viewId = 'trog_resource_browser.view.' . $browserName;
            $container->setDefinition($viewId, $viewDef);

            $registryDef->addMethodCall('register', [ $browserName, new Reference($viewId) ]);
        }
    }
}
