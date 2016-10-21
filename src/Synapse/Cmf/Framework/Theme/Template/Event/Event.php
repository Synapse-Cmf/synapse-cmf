<?php

namespace Synapse\Cmf\Framework\Theme\Template\Event;

use Symfony\Component\EventDispatcher\Event as SymfonyEvent;
use Synapse\Cmf\Framework\Theme\Template\Domain\Command\AbstractCommand;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;

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
     * @var AbstractCommand
     */
    protected $command;

    /**
     * construct.
     *
     * @param Template        $template
     * @param AbstractCommand $command
     */
    public function __construct(Template $template, AbstractCommand $command = null)
    {
        $this->template = $template;
        $this->command = $command;
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
     * Return command which have trigger this event.
     *
     * @return AbstractCommand
     */
    public function getAction()
    {
        return $this->command;
    }
}
