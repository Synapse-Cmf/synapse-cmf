<?php

namespace Synapse\Page\Bundle\Event\Page;

use Symfony\Component\EventDispatcher\Event as SymfonyEvent;
use Synapse\Page\Bundle\Action\Page\AbstractAction;
use Synapse\Page\Bundle\Entity\Page;

/**
 * Page specific event class.
 */
class Event extends SymfonyEvent
{
    /**
     * @var Page
     */
    protected $page;

    /**
     * @var AbstractAction
     */
    protected $action;

    /**
     * construct.
     *
     * @param Page           $page
     * @param AbstractAction $action
     */
    public function __construct(Page $page, AbstractAction $action = null)
    {
        $this->page = $page;
        $this->action = $action;
    }

    /**
     * return related Page.
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Return event subject, alias for getPage().
     *
     * @return Page
     */
    public function getSubject()
    {
        return $this->getPage();
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
