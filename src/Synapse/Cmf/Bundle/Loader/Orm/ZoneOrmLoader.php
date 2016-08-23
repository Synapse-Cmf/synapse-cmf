<?php

namespace Synapse\Cmf\Bundle\Loader\Orm;

use Majora\Framework\Loader\LazyLoaderInterface;
use Synapse\Cmf\Bundle\Entity\Orm\Zone;
use Synapse\Cmf\Framework\Theme\ZoneType\Loader\LoaderInterface as SynapseZoneTypeLoader;
use Synapse\Cmf\Framework\Theme\Zone\Loader\Doctrine\DoctrineLoader as SynapseZoneDoctrineLoader;

/**
 * Zone loader override to register lazy loaders.
 */
class ZoneOrmLoader extends SynapseZoneDoctrineLoader implements LazyLoaderInterface
{
    /**
     * @var SynapseZoneTypeLoader
     */
    protected $zoneTypeLoader;

    /**
     * Construct.
     *
     * @param SynapseZoneTypeLoader $zoneTypeLoader
     */
    public function __construct(SynapseZoneTypeLoader $zoneTypeLoader)
    {
        $this->zoneTypeLoader = $zoneTypeLoader;
    }

    /**
     * @see LazyLoaderInterface::getLoadingDelegates()
     */
    public function getLoadingDelegates()
    {
        return array(
            'zoneType' => function (Zone $zone) {
                return $this->zoneTypeLoader->retrieve($zone->getZoneTypeId());
            },
        );
    }
}
