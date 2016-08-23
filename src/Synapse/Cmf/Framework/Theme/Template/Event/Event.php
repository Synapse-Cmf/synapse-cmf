<?php

namespace Synapse\Cmf\Framework\Theme\Template\Event;

use Synapse\Cmf\Framework\Theme\Template\Action\AbstractAction;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * Template specific event class.
 */
class Event extends SymfonyEvent
{
    /**
     * @var Template
     */
    protected $template;

    /**
     * @var AbstractAction
     */
    protected $action;

    /**
     * construct.
     *
     * @param Template       $template
     * @param AbstractAction $action
     */
    public function __construct(Template $template, AbstractAction $action = null)
    {
        $this->template = $template;
        $this->action = $action;
    }

    /**
     * return related Template.
     *
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Return event subject, alias for getTemplate().
     *
     * @return Template
     */
    public function getSubject()
    {
        return $this->getTemplate();
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
