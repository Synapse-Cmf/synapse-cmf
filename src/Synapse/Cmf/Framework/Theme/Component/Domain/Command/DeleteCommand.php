<?php

namespace Synapse\Cmf\Framework\Theme\Component\Domain\Command;

use Majora\Framework\Domain\Action\DynamicActionTrait;
use Synapse\Cmf\Framework\Theme\Component\Event\Event as ComponentEvent;
use Synapse\Cmf\Framework\Theme\Component\Event\Events as ComponentEvents;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;

/**
 * Component deletion action representation.
 */
class DeleteCommand extends AbstractCommand
{
    use DynamicActionTrait;

    /**
     * Initialisation function.
     *
     * @param ComponentInterface $component
     */
    public function init(ComponentInterface $component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * @see CommandInterface::resolve()
     */
    public function resolve()
    {
        $this->fireEvent(
            ComponentEvents::COMPONENT_DELETED,
            new ComponentEvent($this->component, $this)
        );
    }
}
