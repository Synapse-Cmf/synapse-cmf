<?php

namespace Synapse\Cmf\Framework\Media\Image\Event;

/**
 * Image events reference class.
 */
final class Events
{
    /**
     * event fired when a image is created.
     */
    const IMAGE_CREATED = 'synapse.image.created';

    /**
     * event fired when a image is updated.
     */
    const IMAGE_EDITED = 'synapse.image.edited';

    /**
     * event fired when a image is deleted.
     */
    const IMAGE_DELETED = 'synapse.image.deleted';
}
