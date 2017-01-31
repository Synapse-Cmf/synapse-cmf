<?php

namespace Synapse\Cmf\Bundle\Distribution\Theme\Bundle;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * Theme config semantic parser.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @var array
     */
    private $enabledContentTypes;

    /**
     * @var array
     */
    private $enabledComponentTypes;

    /**
     * Construct.
     *
     * @param array $enabledContentTypes
     * @param array $enabledComponentTypes
     */
    public function __construct(array $enabledContentTypes, array $enabledComponentTypes)
    {
        $this->enabledContentTypes = $enabledContentTypes;
        $this->enabledComponentTypes = $enabledComponentTypes;
    }

    /**
     * Validate given array keys are all registered components.
     *
     * @param array $v
     *
     * @return array
     */
    private function validateComponentKeys(array $v)
    {
        $diff = array_diff_key($v, array_flip($this->enabledComponentTypes));
        if (!empty($diff)) {
            throw new InvalidConfigurationException(sprintf(
                'Only "%s" component types are supported for configuration, "%s" more given.',
                implode('", "', $this->enabledComponentTypes),
                implode('", "', array_keys($diff))
            ));
        }

        return $v;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('synapse')
            ->info('Define themes structure, templates, zones and components. You have to define at least one.')
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->arrayNode('structure')
                        ->isRequired()
                        ->requiresAtLeastOneElement()
                        ->useAttributeAsKey('name')
                        ->prototype('array') // templates
                            ->useAttributeAsKey('name')
                            ->prototype('array') // zones
                                ->useAttributeAsKey('name')
                                ->prototype('array') // components
                                ->end()
                                ->validate()
                                    ->always()
                                    ->then(function ($v) {
                                        return $this->validateComponentKeys($v);
                                    })
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->append($this
                        ->createVariableNode('templates', 'hydrateTemplatesNode')
                            ->requiresAtLeastOneElement()
                    )
                    ->append($this
                        ->createVariableNode('zones', 'hydrateZonesNode')
                    )
                    ->append($this
                        ->createVariableNode('components', 'hydrateComponentsNode')
                        ->validate()
                            ->always()
                            ->then(function ($v) {
                                return $this->validateComponentKeys($v);
                            })
                        ->end()
                    )
                    ->arrayNode('image_formats')
                        ->useAttributeAsKey('name')
                        ->prototype('array') // formats
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->enumNode('strategy')
                                    ->defaultValue('crop')
                                    ->values(array('resize', 'crop'))
                                ->end()
                                ->integerNode('width')
                                    ->isRequired()
                                    ->min(1)
                                ->end()
                                ->integerNode('height')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    private function createVariableNode($nodeName, $hydrationStrategy)
    {
        $builder = new TreeBuilder();
        $node = $builder->root($nodeName);
        $prototype = $node
            ->isRequired()
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->addDefaultsIfNotSet()
                ->children()
        ;
        $prototype = $this->$hydrationStrategy($prototype);
        $prototype
                ->append($this->createVariationsNode($hydrationStrategy))
                ->end()
            ->end()
        ;

        return $node;
    }

    private function createVariationsNode($hydrationStrategy)
    {
        $builder = new TreeBuilder();
        $thenNode = $builder->root('variations')
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('_if')
                        ->isRequired()
                    ->end()
                    ->booleanNode('_last')
                        ->defaultFalse()
                    ->end()
                    ->arrayNode('_then')
                        ->isRequired()
                        ->addDefaultsIfNotSet()
                        ->children()
        ;
        $thenNode = $this->$hydrationStrategy($thenNode);
        $variationNode = $thenNode
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $variationNode;
    }

    /**
     * Hydrate given node with templates configuration nodes.
     *
     * @param NodeBuilder $node
     *
     * @return NodeBuilder
     */
    private function hydrateTemplatesNode(NodeBuilder $node)
    {
        $node
            ->booleanNode('default')
                ->defaultFalse()
            ->end()
            ->scalarNode('path')
                ->cannotBeEmpty()
            ->end()
            ->arrayNode('contents')
                ->prototype('scalar')
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Hydrate given node with zones configuration nodes.
     *
     * @param NodeBuilder $node
     *
     * @return NodeBuilder
     */
    private function hydrateZonesNode(NodeBuilder $node)
    {
        $node
            ->booleanNode('main')
                ->defaultFalse()
            ->end()
            ->booleanNode('virtual')
                ->defaultFalse()
            ->end()
            ->arrayNode('aggregation')
                ->addDefaultsIfNotSet()
                ->beforeNormalization()
                    ->always(function ($v) {
                        if (is_string($v)) {   // shortcut case
                            $v = array('type' => $v);
                        }
                        if (is_array($v) && !empty($v['path'])) {   // path shortcut case
                            $v['type'] = 'template';
                        }

                        return $v;
                    })
                ->end()
                ->children()
                    ->scalarNode('type')
                        ->defaultValue('inline')
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('path')->end()
                ->end()
            ->end()
        ;

        return $node;
    }

    /**
     * Hydrate given node with components configuration nodes.
     *
     * @param NodeBuilder $node
     *
     * @return NodeBuilder
     */
    private function hydrateComponentsNode(NodeBuilder $node)
    {
        $node
            ->scalarNode('path')->end()
            ->scalarNode('controller')->end()
            ->arrayNode('config')
                ->useAttributeAsKey('name')
                ->prototype('array')
                    ->useAttributeAsKey('name')
                    ->beforeNormalization()
                        ->always(function ($v) {
                            if (is_bool($v)) {
                                return array('enabled' => $v);
                            }

                            return $v;
                        })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $node;
    }
}
