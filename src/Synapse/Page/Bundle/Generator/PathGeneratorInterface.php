<?php

namespace Synapse\Page\Bundle\Generator;

use Synapse\Page\Bundle\Entity\Page;

/**
 * Page pathes encoder behavior definition.
 */
interface PathGeneratorInterface
{
    /**
     * Generate and returns a path for given page and slug.
     *
     * @param Page   $page
     * @param string $slug
     *
     * @return string
     */
    public function generatePath(Page $page, $slug);
}
