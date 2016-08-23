<?php

namespace Synapse\Cmf\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SynapseCmfExtension extends Extension implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // publish into parameters to allow listening
        $container->setParameter('synapse.media_store.physical_path', $config['media']['store']['physical_path']);
        $container->setParameter('synapse.media_store.web_path', $config['media']['store']['web_path']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        // register components into memory
        if (!empty($config['components'])) {
            $componentData = array();
            foreach ($config['components'] as $name => $data) {
                if (empty($data)) {
                    continue;
                }
                $componentData[] = array(
                    'id' => $name,
                    'name' => $name,
                    'controller' => $data['controller'],
                    'template_path' => $data['template_path'],
                    'form_type' => $data['form'],
                );
            }
            $container->getDefinition('synapse.component_type.in_memory_loader')
                ->addMethodCall('registerData', array($componentData))
            ;
            $container->setParameter('synapse.component_types', array_keys($config['components']));
        }

        // register content types into memory
        if (!empty($config['content_types'])) {
            $contentTypeData = array();
            $contentTypeNames = array();
            foreach ($config['content_types'] as $class => $data) {
                $contentTypeData[] = array(
                    'id' => $data['alias'],
                    'name' => $data['alias'],
                    'contentClass' => $class,
                    'contentProvider' => new Reference($data['provider']),
                );
                $contentTypeNames[] = $data['alias'];
            }
            $container->getDefinition('synapse.content_type.in_memory_loader')
                ->addMethodCall('registerData', array($contentTypeData))
            ;
            $container->setParameter('synapse.content_types', $contentTypeNames);
        }

        // forms enabled ?
        if (!empty($config['forms']['enabled'])) {
            $loader->load('services/forms.xml');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $container->getParameterBag()->remove('synapse.component_types');
        $container->getParameterBag()->remove('synapse.content_types');
    }
}
