<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Entity;

use Majora\Framework\Model\EntityCollection;

/**
 * FormattedImage entity collection class.
 */
class FormattedImageCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return FormattedImage::class;
    }
}
