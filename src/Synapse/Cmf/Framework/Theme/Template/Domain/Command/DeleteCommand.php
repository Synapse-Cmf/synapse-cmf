<?php

namespace Synapse\Cmf\Framework\Theme\Template\Domain\Command;

use Synapse\Cmf\Framework\Theme\Template\Event\Event as TemplateEvent;
use Synapse\Cmf\Framework\Theme\Template\Event\Events as TemplateEvents;

/**
 * Template deletion command representation.
 */
class DeleteCommand extends AbstractCommand
{
    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->fireEvent(
            TemplateEvents::TEMPLATE_DELETED,
            new TemplateEvent($this->template, $this)
        );
    }
}
