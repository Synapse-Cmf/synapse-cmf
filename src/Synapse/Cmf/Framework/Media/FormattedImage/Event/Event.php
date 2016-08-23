<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Event;

use Synapse\Cmf\Framework\Media\FormattedImage\Action\AbstractAction;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * FormattedImage specific event class.
 */
class Event extends SymfonyEvent
{
    /**
     * @var FormattedImage
     */
    protected $formattedImage;

    /**
     * @var AbstractAction
     */
    protected $action;

    /**
     * construct.
     *
     * @param FormattedImage $formattedImage
     * @param AbstractAction $action
     */
    public function __construct(FormattedImage $formattedImage, AbstractAction $action = null)
    {
        $this->formattedImage = $formattedImage;
        $this->action = $action;
    }

    /**
     * return related FormattedImage.
     *
     * @return FormattedImage
     */
    public function getFormattedImage()
    {
        return $this->formattedImage;
    }

    /**
     * Return event subject, alias for getFormattedImage().
     *
     * @return FormattedImage
     */
    public function getSubject()
    {
        return $this->getFormattedImage();
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
