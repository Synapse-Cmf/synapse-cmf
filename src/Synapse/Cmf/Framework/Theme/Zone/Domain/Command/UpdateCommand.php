<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Domain\Command;

use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\Zone\Event\Event as ZoneEvent;
use Synapse\Cmf\Framework\Theme\Zone\Event\Events as ZoneEvents;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Zone edition command representation.
 */
class UpdateCommand extends AbstractCommand
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
    public function init(ZoneInterface $zone)
    {
        $this->zone = $zone;
        $this->components = $zone->getComponents()->indexBy('id');

        return $this;
    }

    /**
     * Edition trigger method.
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
