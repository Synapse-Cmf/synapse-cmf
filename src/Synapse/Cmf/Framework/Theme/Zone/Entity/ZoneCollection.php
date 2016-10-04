<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * Zone entity collection class.
 */
class ZoneCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return Zone::class;
    }

    /**
     * Sort zones by zone type order, ascending order.
     *
     * @return ZoneCollection
     */
    public function sortByZoneType()
    {
        return new self($this
            ->sort(function (Zone $zone1, Zone $zone2) {
                $zone1Order = $zone1->getZoneType()->getOrder();
                $zone2Order = $zone2->getZoneType()->getOrder();

                // implement alpha sort on name if equal ?

                return $zone1Order >= $zone2Order ? 1 : -1;
            })
            ->toArray()
        );
    }

    /**
     * Index this collection by zone type name.
     *
     * @return ZoneCollection
     */
    public function indexByZoneType()
    {
        $zoneCollection = array();
        foreach ($this as $zone) {
            $zoneCollection[$zone->getZoneType()->getName()] = $zone;
        }

        return new self($zoneCollection);
    }
}
