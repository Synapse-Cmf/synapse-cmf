<?php

namespace Synapse\Cmf\Framework\Media\Video\Event;

use Synapse\Cmf\Framework\Media\Video\Action\AbstractAction;
use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Symfony\Component\EventDispatcher\Event as SymfonyEvent;

/**
 * Video specific event class.
 */
class Event extends SymfonyEvent
{
    /**
     * @var Video
     */
    protected $video;

    /**
     * @var AbstractAction
     */
    protected $action;

    /**
     * construct.
     *
     * @param Video          $video
     * @param AbstractAction $action
     */
    public function __construct(Video $video, AbstractAction $action = null)
    {
        $this->video = $video;
        $this->action = $action;
    }

    /**
     * return related Video.
     *
     * @return Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Return event subject, alias for getVideo().
     *
     * @return Video
     */
    public function getSubject()
    {
        return $this->getVideo();
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
