<?php

namespace Synapse\Cmf\Framework\Theme\ContentType\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * ContentType entity collection class.
 */
class ContentTypeCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return ContentType::class;
    }
}
