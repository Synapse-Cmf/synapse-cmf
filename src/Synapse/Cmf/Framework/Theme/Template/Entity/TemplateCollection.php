<?php

namespace Synapse\Cmf\Framework\Theme\Template\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * Template entity collection class.
 */
class TemplateCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return Template::class;
    }
}
