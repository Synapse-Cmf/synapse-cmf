<?php

namespace Synapse\Cmf\Framework\Theme\Theme\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * Theme entity collection class.
 */
class ThemeCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return Theme::class;
    }
}
