<?php

namespace Synapse\Cmf\Bundle\Distribution\Theme\Bundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\Bundle\Bundle as SymfonyBundle;
use Symfony\Component\Yaml\Yaml;

/**
 * Base class for theme bundles.
 */
class Bundle extends SymfonyBundle
{
    /**
     * override build to register theme configuration.
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $configFile = new SplFileInfo(
            (new FileLocator($this->getPath().'/Resources/config'))
                ->locate('synapse.yml'),
            '',
            ''
        );

        $container->addCompilerPass(new CompilerPass(
            Yaml::parse($configFile->getContents())
        ));
        $container->addResource(new FileResource(
            $configFile->getRealPath()
        ));
    }
}
