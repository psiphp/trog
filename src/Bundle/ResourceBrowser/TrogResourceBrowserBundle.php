<?php

namespace Trog\Bundle\ResourceBrowser;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Trog\Bundle\ResourceBrowser\DependencyInjection\Compiler\AcceptorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TrogResourceBrowserBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AcceptorPass());
    }
}
