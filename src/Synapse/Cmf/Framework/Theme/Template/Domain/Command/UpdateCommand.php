<?php

namespace Synapse\Cmf\Framework\Theme\Template\Domain\Command;

use Synapse\Cmf\Framework\Theme\Template\Event\Event as TemplateEvent;
use Synapse\Cmf\Framework\Theme\Template\Event\Events as TemplateEvents;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;

/**
 * Template edition command representation.
 */
class UpdateCommand extends AbstractCommand
{
    /**
     * Initialisation function.
     *
     * @param TemplateInterface $template
     */
    public function init(TemplateInterface $template)
    {
        $this->template = $template;
        $this->zones = $template->getZones()
            ->sortByZoneType()->indexByZoneType()
        ;

        return $this;
    }

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->template->setZones($this->zones);

        $this->template->denormalize($this->normalize('update'));

        $this->assertEntityIsValid($this->template, array('Template', 'edition'));

        $this->eventDispatcher->addListener(
            TemplateEvents::TEMPLATE_EDITED,
            $handler = array($this, 'onTemplateCreated')
        );
        $this->fireEvent(
            TemplateEvents::TEMPLATE_EDITED,
            new TemplateEvent($this->template, $this)
        );
        $this->eventDispatcher->removeListener(TemplateEvents::TEMPLATE_EDITED, $handler);
    }
}
