<?php

namespace Synapse\Cmf\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;

/**
 * Synapse Cmf Bundle semantical configuration class.
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
        $treeBuilder->root('synapse_cmf')
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('forms')
                    ->canBeEnabled()
                ->end()
                ->arrayNode('media')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('store')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('physical_path')
                                    ->cannotBeEmpty()
                                    ->defaultValue('%kernel.root_dir%/../web/assets/')
                                    ->beforeNormalization()
                                        ->ifString()
                                        ->then(function ($v) {
                                            return sprintf('/%s/', trim($v, '/'));
                                        })
                                    ->end()
                                ->end()
                                ->scalarNode('web_path')
                                    ->cannotBeEmpty()
                                    ->defaultValue('assets')
                                    ->beforeNormalization()
                                        ->ifString()
                                        ->then(function ($v) {
                                            return trim($v, '/');
                                        })
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('components')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('controller')
                                ->isRequired()->cannotBeEmpty()
                            ->end()
                            ->scalarNode('template_path')
                                ->isRequired()->cannotBeEmpty()
                            ->end()
                            ->scalarNode('form')
                                ->isRequired()->cannotBeEmpty()
                            ->end()
                            ->arrayNode('config')
                                ->useAttributeAsKey('name')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('content_types')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('alias')
                                ->isRequired()->cannotBeEmpty()
                            ->end()
                            ->scalarNode('provider')
                                ->isRequired()->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                    ->validate()
                        ->ifTrue(function ($v) {
                            foreach ($v as $class => $data) {
                                if (!class_exists($class, true)
                                    || !is_a($class, ContentInterface::class, true)
                                ) {
                                    return true;
                                }
                            }
                        })
                        ->thenInvalid('Content types have to be Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface objects.')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
