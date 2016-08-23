<?php

namespace Synapse\Cmf\Framework\Theme\ContentType\Loader\InMemory;

use Majora\Framework\Loader\Bridge\InMemory\AbstractInMemoryLoader;
use Majora\Framework\Loader\Bridge\InMemory\InMemoryLoaderTrait;
use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentType;
use Synapse\Cmf\Framework\Theme\ContentType\Loader\LoaderInterface;

/**
 * ContentType loader implementation using server memory.
 */
class InMemoryLoader extends AbstractInMemoryLoader implements LoaderInterface
{
    use InMemoryLoaderTrait;

    /**
     * @see LoaderInterface::retrieveByContentClass()
     */
    public function retrieveByContentClass($contentClass)
    {
        return $this->retrieveAll()->filter(function (ContentType $content) use ($contentClass) {
            return is_a($content->getContentClass(), $contentClass, true);
        });
    }
}
