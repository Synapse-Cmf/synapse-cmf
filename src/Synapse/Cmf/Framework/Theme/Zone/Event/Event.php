<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Event;

use Symfony\Component\EventDispatcher\Event as SymfonyEvent;
use Synapse\Cmf\Framework\Theme\Zone\Domain\Command\AbstractCommand;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;

/**
 * Zone specific event class.
 */
class Event extends SymfonyEvent
{
    /**
     * @var Zone
     */
    protected $zone;

    /**
     * @var AbstractCommand
     */
    protected $action;

    /**
     * construct.
     *
     * @param Zone            $zone
     * @param AbstractCommand $action
     */
    public function __construct(Zone $zone, AbstractCommand $action = null)
    {
        $this->zone = $zone;
        $this->action = $action;
    }

    /**
     * return related Zone.
     *
     * @return Zone
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Return event subject, alias for getZone().
     *
     * @return Zone
     */
    public function getSubject()
    {
        return $this->getZone();
    }

    /**
     * Return action which have trigger this event.
     *
     * @return AbstractAction
     */
    public function getAction()
    {
        return $this->action;
    }
}
