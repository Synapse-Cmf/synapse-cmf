<?php

namespace Synapse\Page\Bundle\Generator;

use Majora\Framework\Inflector\Inflector;
use Synapse\Page\Bundle\Entity\Page;

/**
 * Page path generator using MajoraInflector to slugify page title with it's ancestors ones.
 */
class SluggedPathGenerator implements PathGeneratorInterface
{
    /**
     * @var Inflector
     */
    protected $inflector;

    /**
     * Construct.
     *
     * @param Inflector $inflector
     */
    public function __construct(Inflector $inflector)
    {
        $this->inflector = $inflector;
    }

    /**
     * @see PathGeneratorInterface::generatePath()
     */
    public function generatePath(Page $page, $slug)
    {
        $page->setSlug($this->inflector->slugify($slug));

        // iterate over ancestors every time to always get actual slug
        // (referencement purposes)
        $parent = $page;
        $pathParts = array();
        do {
            array_unshift($pathParts, $parent->getSlug());
        } while ($parent = $parent->getParent());

        return trim(implode('/', $pathParts), '/');
    }
}
