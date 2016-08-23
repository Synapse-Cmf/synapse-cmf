<?php

namespace Synapse\Cmf\Framework\Theme\Template\Model;

use Majora\Framework\Model\CollectionableInterface;

/**
 * Interface for Template entities use cases.
 */
interface TemplateInterface extends CollectionableInterface
{
    /**
     * Define a content type global template.
     */
    const GLOBAL_SCOPE = 'global';

    /**
     * Define a content instance local template.
     */
    const LOCAL_SCOPE = 'local';
}
