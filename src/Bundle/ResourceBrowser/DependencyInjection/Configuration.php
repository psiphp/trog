<?php

namespace Trog\Bundle\ResourceBrowser\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('trog_column_browser');
        $rootNode->children()
            ->arrayNode('browsers')
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default_repository')
                            ->info('Show this repository by default (set to null to show first available)')
                            ->defaultValue('default')
                        ->end()
                        ->scalarNode('template')
                            ->info('Twig template to use to display the browser')
                            ->defaultValue('@TrogResourceBrowserBundle/index.html.twig')
                        ->end()
                        ->arrayNode('repositories')
                            ->info('Allow selection from these repositories (leave empty for all)')
                            ->prototype('scalar')->end()
                        ->end()
                        ->booleanNode('enable_move')
                            ->info('Enable movement of resources in UI')
                            ->defaultValue(false)
                        ->end()
                        ->booleanNode('enable_item_actions')
                            ->info('Show actions for items')
                            ->defaultValue(false)
                        ->end()
                        ->integerNode('columns')
                            ->info('Number of columns to show at once')
                            ->defaultValue(4)
                        ->end()
                    ->end()
                ->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
