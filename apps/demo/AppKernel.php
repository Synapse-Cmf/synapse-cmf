<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Majora\Bundle\FrameworkExtraBundle\MajoraFrameworkExtraBundle($this),
            new Synapse\Cmf\Bundle\SynapseCmfBundle(),
            new Synapse\Admin\Bundle\SynapseAdminBundle(),
            new Synapse\Page\Bundle\SynapsePageBundle(),
            new Synapse\Demo\Bundle\ThemeBundle\SynapseDemoThemeBundle(),
            new Synapse\Demo\Bundle\AppBundle\SynapseDemoAppBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Majora\Bundle\GeneratorBundle\MajoraGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    /**
     * @see Symfony\Component\HttpKernel\KernelInterface::getCacheDir()
     */
    public function getCacheDir()
    {
        return in_array($this->environment, array('dev', 'test')) && is_writable('/dev/shm') ?
            '/dev/shm/synapse/demo/cache/'.$this->getEnvironment() :
            $this->getRootDir().'/../../var/cache/synapse/demo/'.$this->getEnvironment()
        ;
    }

    /**
     * @see Symfony\Component\HttpKernel\KernelInterface::getLogDir()
     */
    public function getLogDir()
    {
        return in_array($this->environment, array('dev', 'test')) && is_writable('/dev/shm') ?
            '/dev/shm/synapse/demo/logs' :
            $this->getRootDir().'/../../var/logs/synapse/demo'
        ;
    }

    /**
     * @{inherit_doc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
