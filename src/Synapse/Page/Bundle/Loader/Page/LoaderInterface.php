<?php

namespace Synapse\Page\Bundle\Loader\Page;

use Majora\Framework\Loader\LoaderInterface as MajoraLoaderInterface;
use Synapse\Cmf\Framework\Theme\Content\Provider\ContentProviderInterface as SynapseLoaderInterface;

/**
 * Interface for Page loading use cases.
 */
interface LoaderInterface extends MajoraLoaderInterface, SynapseLoaderInterface
{
    /**
     * Retrieve a Page from his path.
     *
     * @param string $path
     * @param bool   $online optionnal online state filter
     *
     * @return Page|null
     */
    public function retrieveByPath($path, $online = null);
}
