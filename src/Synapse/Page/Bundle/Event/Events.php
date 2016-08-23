<?php

namespace Synapse\Page\Bundle\Event;

/**
 * Page events reference class.
 */
final class Events
{
    /**
     * event fired when a page is created.
     */
    const PAGE_CREATED = 'synapse.page.created';

    /**
     * event fired when a page is updated.
     */
    const PAGE_EDITED = 'synapse.page.edited';

    /**
     * event fired when a page is deleted.
     */
    const PAGE_DELETED = 'synapse.page.deleted';
}
