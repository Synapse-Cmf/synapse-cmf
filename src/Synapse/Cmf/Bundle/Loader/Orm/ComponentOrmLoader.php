<?php

namespace Synapse\Cmf\Bundle\Loader\Orm;

use Majora\Framework\Loader\LazyLoaderInterface;
use Synapse\Cmf\Bundle\Entity\Orm\Component;
use Synapse\Cmf\Framework\Theme\ComponentType\Loader\LoaderInterface as SynapseComponentTypeLoader;
use Synapse\Cmf\Framework\Theme\Component\Loader\Doctrine\DoctrineLoader as SynapseComponentDoctrineLoader;

/**
 * Component loader override to register lazy loaders.
 */
class ComponentOrmLoader extends SynapseComponentDoctrineLoader implements LazyLoaderInterface
{
    /**
     * @var SynapseComponentTypeLoader
     */
    protected $componentTypeLoader;

    /**
     * Construct.
     *
     * @param SynapseComponentTypeLoader $componentTypeLoader
     */
    public function __construct(SynapseComponentTypeLoader $componentTypeLoader)
    {
        $this->componentTypeLoader = $componentTypeLoader;
    }

    /**
     * @see LazyLoaderInterface::getLoadingDelegates()
     */
    public function getLoadingDelegates()
    {
        return array(
            'componentType' => function (Component $component) {
                return $this->componentTypeLoader->retrieve($component->getComponentTypeId());
            },
        );
    }
}
