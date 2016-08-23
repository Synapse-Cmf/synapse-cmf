<?php

namespace Synapse\Cmf\Framework\Theme\Template\Event;

/**
 * Template events reference class.
 */
final class Events
{
    /**
     * event fired when a template is created.
     */
    const TEMPLATE_CREATED = 'synapse.template.created';

    /**
     * event fired when a template is updated.
     */
    const TEMPLATE_EDITED = 'synapse.template.edited';

    /**
     * event fired when a template is deleted.
     */
    const TEMPLATE_DELETED = 'synapse.template.deleted';
}
