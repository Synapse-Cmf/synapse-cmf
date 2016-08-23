<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Domain;

use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Model\ZoneTypeInterface;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Interface for Zone domain use cases.
 */
interface DomainInterface
{
    /**
     * Create and return a new Zone from given ZoneType.
     *
     * @param ZoneTypeInterface   $zoneType
     * @param ComponentCollection $components
     *
     * @return CreateZoneAction
     */
    public function create(ZoneTypeInterface $zone, ComponentCollection $components = null);

    /**
     * Create and returns an action for update a Zone.
     *
     * @param ZoneInterface $zone
     *
     * @return UpdateZoneAction
     */
    public function edit(ZoneInterface $zone);

    /**
     * Create and returns an action for delete a Zone.
     *
     * @param ZoneInterface $zone
     *
     * @return DeleteZoneAction
     */
    public function delete(ZoneInterface $zone);
}
