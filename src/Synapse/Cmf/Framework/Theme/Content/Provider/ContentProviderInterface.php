<?php

namespace Synapse\Cmf\Framework\Theme\Content\Provider;

/**
 * Content provider behavior definition.
 */
interface ContentProviderInterface
{
    /**
     * Retrieve a ContentInterface object from his content id.
     *
     * @return ContentInterface|null
     */
    public function retrieveContent($contentId);
}
