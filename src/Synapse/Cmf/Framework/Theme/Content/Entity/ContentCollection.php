<?php

namespace Synapse\Cmf\Framework\Theme\Content\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * ContentType entity collection class.
 */
class ContentCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return Content::class;
    }
}
