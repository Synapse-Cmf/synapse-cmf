<?php

namespace Synapse\Cmf\Framework\Media\Format\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * Format entity collection class.
 */
class FormatCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return Format::class;
    }
}
