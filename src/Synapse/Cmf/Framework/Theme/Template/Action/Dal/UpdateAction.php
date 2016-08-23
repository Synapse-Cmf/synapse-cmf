<?php

namespace Synapse\Cmf\Framework\Theme\Template\Action\Dal;

use Synapse\Cmf\Framework\Theme\Template\Event\Event as TemplateEvent;
use Synapse\Cmf\Framework\Theme\Template\Event\Events as TemplateEvents;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;

/**
 * Template edition action representation.
 */
class UpdateAction extends AbstractDalAction
{
    /**
     * @var ZoneCollection
     */
    public $zones;

    /**
     * Initialisation function.
     *
     * @param TemplateInterface $template
     */
    public function init(TemplateInterface $template = null)
    {
        if (!$template) {
            return $this;
        }

        $this->template = $template;
        $this->zones = $template->getZones();

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

        $this->fireEvent(
            TemplateEvents::TEMPLATE_EDITED,
            new TemplateEvent($this->template, $this)
        );
    }
}
