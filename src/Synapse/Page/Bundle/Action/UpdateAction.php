<?php

namespace Synapse\Page\Bundle\Action;

use Synapse\Page\Bundle\Entity\Page;
use Synapse\Page\Bundle\Event\Event as PageEvent;
use Synapse\Page\Bundle\Event\Events as PageEvents;

/**
 * Page edition action representation.
 */
class UpdateAction extends AbstractAction
{
    /**
     * Initialisation function.
     *
     * @param Page $page
     */
    public function init(Page $page = null)
    {
        if (!$page) {
            return $this;
        }

        $this->page = $page;
        $this->online = $page->isOnline();
        $this->meta = $page->getMeta();
        $this->openGraph = $page->getOpenGraph();
        $this->title = $page->getTitle();

        return $this;
    }

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->page
            ->setOnline($this->online)
            ->setTitle($this->title)
            ->setMeta(array_replace_recursive(
                array('title' => $this->title),
                $this->meta
            ))
            ->setOpenGraph($this->openGraph)
        ;
        $this->assertEntityIsValid($this->page, array('Page', 'edition'));

        // Adds template promises resolution into event chain
        // to give access to created templates if necessary
        if ($this->synapsePromises) {
            $this->eventDispatcher->addListener(
                PageEvents::PAGE_EDITED,
                function (PageEvent $event) {
                    $this->synapsePromises->resolve();
                },
                -101
            );
        }

        $this->fireEvent(
            PageEvents::PAGE_EDITED,
            new PageEvent($this->page, $this)
        );
    }
}
