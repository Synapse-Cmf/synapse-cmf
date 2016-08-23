<?php

namespace Synapse\Cmf\Framework\Theme\Component\Action\Dal;

use Synapse\Cmf\Framework\Theme\Component\Event\Event as ComponentEvent;
use Synapse\Cmf\Framework\Theme\Component\Event\Events as ComponentEvents;
use Majora\Framework\Domain\Action\DynamicActionTrait;

/**
 * Component deletion action representation.
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
            ComponentEvents::COMPONENT_DELETED,
            new ComponentEvent($this->component, $this)
        );
    }
}
