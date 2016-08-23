<?php

namespace Synapse\Cmf\Framework\Theme\ZoneType\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * ZoneType entity collection class.
 */
class ZoneTypeCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return ZoneType::class;
    }
}
