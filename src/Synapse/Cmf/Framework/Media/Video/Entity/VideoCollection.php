<?php

namespace Synapse\Cmf\Framework\Media\Video\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * Video entity collection class.
 */
class VideoCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return Video::class;
    }
}
