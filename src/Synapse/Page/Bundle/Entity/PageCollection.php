<?php

namespace Synapse\Page\Bundle\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * Page entity collection class.
 */
class PageCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return Page::class;
    }
}
