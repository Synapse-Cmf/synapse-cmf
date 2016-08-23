<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Event;

/**
 * FormattedImage events reference class.
 */
final class Events
{
    /**
     * event fired when a formatted_image is created.
     */
    const FORMATTED_IMAGE_CREATED = 'synapse.formatted_image.created';

    /**
     * event fired when a formatted_image is updated.
     */
    const FORMATTED_IMAGE_EDITED = 'synapse.formatted_image.edited';

    /**
     * event fired when a formatted_image is deleted.
     */
    const FORMATTED_IMAGE_DELETED = 'synapse.formatted_image.deleted';
}
