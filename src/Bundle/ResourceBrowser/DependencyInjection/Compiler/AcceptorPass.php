<?php

namespace Trog\Bundle\ResourceBrowser\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AcceptorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('trog_resource_browser.acceptor_registry')) {
            return;
        }

        $registryDef = $container->getDefinition('trog_resource_browser.acceptor_registry');
        $acceptorIds = $container->findTaggedServiceIds('trog_resource_browser.filter.acceptor');

        $acceptorRefs = [];
        foreach ($acceptorIds as $acceptorId => $attributes) {
            $attributes = $attributes[0];

            if (!isset($attributes['alias'])) {
                throw new \InvalidArgumentException(sprintf(
                    'Filter acceptor "%s" has no "alias" attribute in its tag',
                    $acceptorId
                ));
            }

            $alias = $attributes['alias'];

            $acceptorRefs[$alias] = new Reference($acceptorId);
        }

        $registryDef->replaceArgument(0, $acceptorRefs);
    }
}
