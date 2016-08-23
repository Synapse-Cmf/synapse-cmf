<?php

namespace Synapse\Cmf\Framework\Media\Image\Event;

use Synapse\Cmf\Framework\Media\Image\Action\AbstractAction;
use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * Image specific event class.
 */
class Event extends SymfonyEvent
{
    /**
     * @var Image
     */
    protected $image;

    /**
     * @var AbstractAction
     */
    protected $action;

    /**
     * construct.
     *
     * @param Image          $image
     * @param AbstractAction $action
     */
    public function __construct(Image $image, AbstractAction $action = null)
    {
        $this->image = $image;
        $this->action = $action;
    }

    /**
     * return related Image.
     *
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Return event subject, alias for getImage().
     *
     * @return Image
     */
    public function getSubject()
    {
        return $this->getImage();
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
