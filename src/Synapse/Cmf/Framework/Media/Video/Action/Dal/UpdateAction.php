<?php

namespace Synapse\Cmf\Framework\Media\Video\Action\Dal;

use Synapse\Cmf\Framework\Media\Video\Event\Event as VideoEvent;
use Synapse\Cmf\Framework\Media\Video\Event\Events as VideoEvents;
use Majora\Framework\Domain\Action\DynamicActionTrait;

/**
 * Video edition action representation.
 */
class UpdateAction extends AbstractDalAction
{
    use DynamicActionTrait;

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->video->denormalize($this->normalize('update'));

        $this->assertEntityIsValid($this->video, array('Video', 'edition'));

        $this->fireEvent(
            VideoEvents::VIDEO_EDITED,
            new VideoEvent($this->video, $this)
        );
    }
}
