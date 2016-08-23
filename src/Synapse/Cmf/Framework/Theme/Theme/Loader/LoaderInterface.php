<?php

namespace Synapse\Cmf\Framework\Theme\Theme\Loader;

use Majora\Framework\Loader\LoaderInterface as MajoraLoaderInterface;

/**
 * Interface for Theme loading use cases.
 */
interface LoaderInterface extends MajoraLoaderInterface
{
    /**
     * Returns a theme from his name.
     *
     * @param string $name
     *
     * @return ThemeInterface|null
     */
    public function retrieveByName($name);
}
