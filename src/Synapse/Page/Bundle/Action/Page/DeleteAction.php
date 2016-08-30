<?php

namespace Synapse\Page\Bundle\Action\Page;

use Majora\Framework\Domain\Action\DynamicActionTrait;
use Synapse\Page\Bundle\Event\Page\Event as PageEvent;
use Synapse\Page\Bundle\Event\Page\Events as PageEvents;

/**
 * Page deletion action representation.
 */
class DeleteAction extends AbstractAction
{
    use DynamicActionTrait;

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->fireEvent(
            PageEvents::PAGE_DELETED,
            new PageEvent($this->page, $this)
        );
    }
}
