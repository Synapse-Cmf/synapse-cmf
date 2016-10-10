<?php

namespace Synapse\Cmf\Framework\Theme\Component\Event;

use Symfony\Component\EventDispatcher\Event as SymfonyEvent;
use Synapse\Cmf\Framework\Theme\Component\Domain\Command\AbstractCommand;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;

/**
 * Component specific event class.
 */
class Event extends SymfonyEvent
{
    /**
     * @var Component
     */
    protected $component;

    /**
     * @var AbstractCommand
     */
    protected $action;

    /**
     * construct.
     *
     * @param Component       $component
     * @param AbstractCommand $action
     */
    public function __construct(Component $component, AbstractCommand $action = null)
    {
        $this->component = $component;
        $this->action = $action;
    }

    /**
     * return related Component.
     *
     * @return Component
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Return event subject, alias for getComponent().
     *
     * @return Component
     */
    public function getSubject()
    {
        return $this->getComponent();
    }

    /**
     * Return action which have trigger this event.
     *
     * @return AbstractCommand
     */
    public function getAction()
    {
        return $this->action;
    }
}
