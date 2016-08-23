<?php

namespace Synapse\Cmf\Framework\Media\Video\Action\Dal;

use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Event\Event as VideoEvent;
use Synapse\Cmf\Framework\Media\Video\Event\Events as VideoEvents;
use Majora\Framework\Domain\Action\DynamicActionTrait;

/**
 * Video creation action representation.
 */
class CreateAction extends AbstractDalAction
{
    use DynamicActionTrait;

    /**
     * Video creation method.
     *
     * @return Video
     */
    public function resolve()
    {
        $this->video = new Video();
        $this->video->denormalize($this->normalize('create'));

        $this->assertEntityIsValid($this->video, array('Video', 'creation'));

        $this->fireEvent(
            VideoEvents::VIDEO_CREATED,
            new VideoEvent($this->video, $this)
        );

        return $this->video;
    }
}
