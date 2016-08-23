<?php

namespace Synapse\Cmf\Framework\Media\Media\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * Media entity collection class.
 */
class MediaCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return Media::class;
    }
}
