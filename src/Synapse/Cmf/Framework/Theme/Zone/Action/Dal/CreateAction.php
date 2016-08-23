<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Action\Dal;

use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Model\ZoneTypeInterface;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Event\Event as ZoneEvent;
use Synapse\Cmf\Framework\Theme\Zone\Event\Events as ZoneEvents;

/**
 * Zone creation action representation.
 */
class CreateAction extends AbstractDalAction
{
    /**
     * @var string
     */
    protected $zoneClass;

    /**
     * @var ZoneTypeInterface
     */
    protected $zoneType;

    /**
     * @var ComponentCollection
     */
    protected $components;

    /**
     * Construct.
     *
     * @param string $zoneClass
     */
    public function __construct($zoneClass = Zone::class)
    {
        $this->zoneClass = $zoneClass;
        $this->components = new ComponentCollection();
    }

    /**
     * Zone creation method.
     *
     * @return Zone
     */
    public function resolve()
    {
        $this->zone = new $this->zoneClass();
        $this->zone->setZoneType($this->zoneType);
        $this->zone->setComponents(
            $this->rankComponents($this->components)
        );

        $this->assertEntityIsValid($this->zone, array('Zone', 'creation'));

        $this->fireEvent(
            ZoneEvents::ZONE_CREATED,
            new ZoneEvent($this->zone, $this)
        );

        return $this->zone;
    }

    /**
     * Define action zone type.
     *
     * @param ZoneTypeInterface $zoneType
     *
     * @return self
     */
    public function setZoneType(ZoneTypeInterface $zoneType)
    {
        $this->zoneType = $zoneType;

        return $this;
    }

    /**
     * Define object components.
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
