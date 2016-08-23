<?php

namespace Synapse\Cmf\Framework\Media\File\Event;

/**
 * File events reference class.
 */
final class Events
{
    /**
     * event fired when a file is created.
     */
    const FILE_CREATED = 'synapse.file.created';

    /**
     * event fired when a file is updated.
     */
    const FILE_EDITED = 'synapse.file.edited';

    /**
     * event fired when a file is deleted.
     */
    const FILE_DELETED = 'synapse.file.deleted';
}
