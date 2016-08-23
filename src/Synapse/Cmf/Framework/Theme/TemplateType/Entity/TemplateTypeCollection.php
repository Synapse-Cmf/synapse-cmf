<?php

namespace Synapse\Cmf\Framework\Theme\TemplateType\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * TemplateType entity collection class.
 */
class TemplateTypeCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return TemplateType::class;
    }
}
