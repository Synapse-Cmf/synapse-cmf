<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Action\Dal;

use Synapse\Cmf\Framework\Theme\Zone\Event\Event as ZoneEvent;
use Synapse\Cmf\Framework\Theme\Zone\Event\Events as ZoneEvents;
use Majora\Framework\Domain\Action\DynamicActionTrait;

/**
 * Zone deletion action representation.
 */
class DeleteAction extends AbstractDalAction
{
    use DynamicActionTrait;

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->fireEvent(
            ZoneEvents::ZONE_DELETED,
            new ZoneEvent($this->zone, $this)
        );
    }
}
