<?php

namespace Synapse\Cmf\Framework\Media\File\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * File entity collection class.
 */
class FileCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return File::class;
    }
}
