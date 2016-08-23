<?php

namespace Synapse\Cmf\Framework\Theme\Component\Event;

/**
 * Component events reference class.
 */
final class Events
{
    /**
     * event fired when a component is created.
     */
    const COMPONENT_CREATED = 'synapse.component.created';

    /**
     * event fired when a component is updated.
     */
    const COMPONENT_EDITED = 'synapse.component.edited';

    /**
     * event fired when a component is deleted.
     */
    const COMPONENT_DELETED = 'synapse.component.deleted';
}
