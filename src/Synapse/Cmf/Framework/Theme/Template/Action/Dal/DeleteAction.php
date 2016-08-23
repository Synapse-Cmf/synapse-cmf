<?php

namespace Synapse\Cmf\Framework\Theme\Template\Action\Dal;

use Synapse\Cmf\Framework\Theme\Template\Event\Event as TemplateEvent;
use Synapse\Cmf\Framework\Theme\Template\Event\Events as TemplateEvents;
use Majora\Framework\Domain\Action\DynamicActionTrait;

/**
 * Template deletion action representation.
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
            TemplateEvents::TEMPLATE_DELETED,
            new TemplateEvent($this->template, $this)
        );
    }
}
