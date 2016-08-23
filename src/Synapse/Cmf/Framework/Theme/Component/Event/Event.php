<?php

namespace Synapse\Cmf\Framework\Theme\Component\Event;

use Synapse\Cmf\Framework\Theme\Component\Action\AbstractAction;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

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
     * @var AbstractAction
     */
    protected $action;

    /**
     * construct.
     *
     * @param Component      $component
     * @param AbstractAction $action
     */
    public function __construct(Component $component, AbstractAction $action = null)
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
     * @return AbstractAction
     */
    public function getAction()
    {
        return $this->action;
    }
}
