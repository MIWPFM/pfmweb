<?php

namespace MIW\RestBundle;

use MIW\RestBundle\DependencyInjection\Security\Factory\WSSEFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MIWRestBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new WSSEFactory());
    }
}
