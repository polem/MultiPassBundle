<?php

namespace Polem\MultiPassBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class MultiPassFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.multipass.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('multipass.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProvider))
        ;

        $listenerId = 'security.authentication.listener.multipass.' . $id;
        $strategy = sprintf('multipass.strategy.%s', $config['strategy']);

        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('multipass.security.authentication.listener'));
        $listener ->replaceArgument(10, new Reference($strategy));

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'multipass';
    }

    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);
    }
}
