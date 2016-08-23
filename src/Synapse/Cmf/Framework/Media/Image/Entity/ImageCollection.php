<?php

namespace Synapse\Cmf\Framework\Media\Image\Entity;

use Synapse\Cmf\Framework\Media\Media\Entity\MediaCollection;

/**
 * Image entity collection class.
 */
class ImageCollection extends MediaCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return Image::class;
    }
}
