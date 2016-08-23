<?php

namespace Synapse\Cmf\Framework\Theme\Component\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * Component entity collection class.
 */
class ComponentCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return Component::class;
    }
}
