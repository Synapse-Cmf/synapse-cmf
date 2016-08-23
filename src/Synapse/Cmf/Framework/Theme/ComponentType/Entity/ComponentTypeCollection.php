<?php

namespace Synapse\Cmf\Framework\Theme\ComponentType\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * ComponentType entity collection class.
 */
class ComponentTypeCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return ComponentType::class;
    }
}
