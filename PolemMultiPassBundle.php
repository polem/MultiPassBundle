<?php

namespace Polem\MultiPassBundle;

use Polem\MultipassBundle\DependencyInjection\Security\Factory\MultipassFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PolemMultiPassBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new MultipassFactory());
    }
}
