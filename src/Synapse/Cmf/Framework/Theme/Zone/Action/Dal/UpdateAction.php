<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Action\Dal;

use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\Zone\Event\Event as ZoneEvent;
use Synapse\Cmf\Framework\Theme\Zone\Event\Events as ZoneEvents;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Zone edition action representation.
 */
class UpdateAction extends AbstractDalAction
{
    /**
     * @var ComponentCollection
     */
    protected $components;

    /**
     * Initialisation function.
     *
     * @param ZoneInterface $zone
     */
    public function init(ZoneInterface $zone = null)
    {
        if (!$zone) {
            return $this;
        }

        $this->zone = $zone;
        $this->components = $zone->getComponents();

        return $this;
    }

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->zone->setComponents(
            $this->rankComponents($this->components)
        );

        $this->assertEntityIsValid($this->zone, array('Zone', 'edition'));

        $this->fireEvent(
            ZoneEvents::ZONE_EDITED,
            new ZoneEvent($this->zone, $this)
        );
    }

    /**
     * Returns action components.
     *
     * @return ComponentCollection
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * Define action components.
     *
     * @param ComponentCollection $components
     *
     * @return self
     */
    public function setComponents(ComponentCollection $components)
    {
        $this->components = $components;

        return $this;
    }
}
