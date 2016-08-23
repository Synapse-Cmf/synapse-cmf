<?php

namespace Synapse\Cmf\Bundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Synapse\Cmf\Bundle\DependencyInjection\SynapseCmfExtension;

/**
 * Synapse Cmf bundle class.
 */
class SynapseCmfBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/Resources/config')
        );
        $loader->load('config.yml');

        $container->addCompilerPass(
            $this->getContainerExtension(),
            PassConfig::TYPE_REMOVE
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensionClass()
    {
        return SynapseCmfExtension::class;
    }
}
