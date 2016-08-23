<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Event;

/**
 * Zone events reference class.
 */
final class Events
{
    /**
     * event fired when a zone is created.
     */
    const ZONE_CREATED = 'synapse.zone.created';

    /**
     * event fired when a zone is updated.
     */
    const ZONE_EDITED = 'synapse.zone.edited';

    /**
     * event fired when a zone is deleted.
     */
    const ZONE_DELETED = 'synapse.zone.deleted';
}
