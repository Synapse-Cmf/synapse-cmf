<?php

namespace Synapse\Admin\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Synapse Admin Bundle semantical configuration class.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     *
     * @see http://symfony.com/doc/current/components/config/definition.html
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('synapse_admin')
            ->children()
                ->scalarNode('base_layout')
                    ->cannotBeEmpty()
                    ->defaultValue('SynapseAdminBundle::base.html.twig')
                ->end()
                ->scalarNode('front_assets_package')
                    ->defaultNull()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
