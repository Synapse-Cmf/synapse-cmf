<?php

namespace Synapse\Cmf\Framework\Media\Video\Event;

/**
 * Video events reference class.
 */
final class Events
{
    /**
     * event fired when a video is created.
     */
    const VIDEO_CREATED = 'synapse.video.created';

    /**
     * event fired when a video is updated.
     */
    const VIDEO_EDITED = 'synapse.video.edited';

    /**
     * event fired when a video is deleted.
     */
    const VIDEO_DELETED = 'synapse.video.deleted';
}
