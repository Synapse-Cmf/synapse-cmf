<?php

namespace Synapse\Cmf\Bundle\Distribution\Theme\Bundle;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Compiler pass which parse given theme data and register entity creation into loaders.
 */
class CompilerPass implements CompilerPassInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Construct.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @see CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('synapse')) {
            throw new \RuntimeException('Cannot use Synapse Theme bundle distribution without Synapse enabled. Maybe you forgot to include SynapseCmfBundle ?');
        }

        $config = (new Processor())->processConfiguration(
            new Configuration(
                $container->getParameter('synapse.content_types'),
                $container->getParameter('synapse.component_types')
            ),
            $this->config
        );

        $variationResolver = $container->getDefinition('synapse.variation.resolver');
        $themeLoaderDefinition = $container->getDefinition('synapse.theme.in_memory_loader');
        $templateTypeLoaderDefinition = $container->getDefinition('synapse.template_type.in_memory_loader');
        $zoneTypeLoaderDefinition = $container->getDefinition('synapse.zone_type.in_memory_loader');
        $imageFormatLoaderDefinition = $container->getDefinition('synapse.image_format.in_memory_loader');

        foreach ($config as $themeName => $themeConfig) {

            // theme structure registering

            $indexedThemeData = array();
            foreach ($themeConfig['structure'] as $templateName => $zones) {
                $templateTypeId = sprintf('%s.%s', $themeName, $templateName);
                $indexedThemeData[$templateTypeId] = array();

                $i = 0;
                foreach ($zones as $zoneName => $components) {
                    $zoneTypeId = sprintf('%s.%s.%s', $themeName, $templateName, $zoneName);
                    $zoneTypeLoaderDefinition->addMethodCall('registerZoneType', array(
                        $indexedThemeData[$templateTypeId][$zoneTypeId] = array(
                            'id' => $zoneTypeId,
                            'name' => $zoneName,
                            'order' => ++$i,
                            'components' => array_keys($components),
                        ),
                    ));
                }
                $templateTypeLoaderDefinition->addMethodCall('registerTemplateType', array(
                    $indexedThemeData[$templateTypeId] = array(
                        'id' => $templateTypeId,
                        'name' => $templateName,
                        'zones' => array_keys($indexedThemeData[$templateTypeId]),
                    ),
                ));
            }

            // image formats registering

            $themeImageFormatData = array();
            foreach ($themeConfig['image_formats'] as $formatName => $formatData) {
                $formatId = sprintf('%s.%s', $themeName, $formatName);
                $themeImageFormatData[$formatId] = array_replace($formatData, array(
                    'id' => $formatId,
                    'name' => $formatName,
                ));
            }
            $imageFormatLoaderDefinition->addMethodCall('registerData', array(
                $themeImageFormatData,
            ));

            // variations building

            $variationResolver->addMethodCall('registerVariationConfig', array(
                $themeName,
                array(
                    'templates' => $themeConfig['templates'],
                    'zones' => $themeConfig['zones'],
                    'components' => $themeConfig['components'],
                ),
            ));

            // Theme registering

            $themeLoaderDefinition->addMethodCall('registerTheme', array(array(
                'id' => $themeName,
                'name' => $themeName,
                'templates' => array_keys($indexedThemeData),
                'image_formats' => array_keys($themeImageFormatData),
            )));
        }
    }
}
