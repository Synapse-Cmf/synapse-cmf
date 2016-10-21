<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Domain;

use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Model\ZoneTypeInterface;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Interface for Zone domain use cases.
 */
interface DomainInterface
{
    /**
     * Create and return a new Zone from given ZoneType and optionnale Component collection.
     *
     * @param ZoneTypeInterface   $zoneType
     * @param ComponentCollection $components
     *
     * @return ZoneInterface
     */
    public function create(ZoneTypeInterface $zone, ComponentCollection $components = null);

    /**
     * Update given Zone component collection.
     *
     * @param ZoneTypeInterface   $zoneType
     * @param ComponentCollection $components
     */
    public function edit(ZoneInterface $zone, ComponentCollection $components);

    /**
     * Adds a new Component for given ComponentType in this zone.
     *
     * @param ZoneInterface          $zone
     * @param ComponentTypeInterface $componentType
     * @param array                  $componentData
     *
     * @return ComponentInterface
     */
    public function addComponent(ZoneInterface $zone, ComponentTypeInterface $componentType, array $componentData = array());
}
