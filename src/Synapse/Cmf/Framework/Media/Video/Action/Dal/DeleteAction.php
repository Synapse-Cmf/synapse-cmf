<?php

namespace Synapse\Cmf\Framework\Media\Video\Action\Dal;

use Synapse\Cmf\Framework\Media\Video\Event\Event as VideoEvent;
use Synapse\Cmf\Framework\Media\Video\Event\Events as VideoEvents;
use Majora\Framework\Domain\Action\DynamicActionTrait;

/**
 * Video deletion action representation.
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
            VideoEvents::VIDEO_DELETED,
            new VideoEvent($this->video, $this)
        );
    }
}
