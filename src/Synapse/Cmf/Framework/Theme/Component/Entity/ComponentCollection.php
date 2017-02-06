<?php

namespace Synapse\Cmf\Framework\Theme\Component\Entity;

use Majora\Framework\Model\EntityCollection;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;

/**
 * Component entity collection class.
 */
class ComponentCollection extends EntityCollection
{
    /**
     * @see EntityCollection::getEntityClass()
     */
    public function getEntityClass()
    {
        return Component::class;
    }

    /**
     * Build ranking index for this collection of components.
     *
     * @return self
     */
    public function buildRanking()
    {
        $i = 0;

        return $this->map(function (ComponentInterface $component) use (&$i) {
            return $component->setRanking(++$i);
        });
    }
}
