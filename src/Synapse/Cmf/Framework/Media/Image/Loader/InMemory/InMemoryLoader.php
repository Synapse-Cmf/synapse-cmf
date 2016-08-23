<?php

namespace Synapse\Cmf\Framework\Media\Image\Loader\InMemory;

use Synapse\Cmf\Framework\Media\Image\Loader\LoaderInterface;
use Majora\Framework\Loader\Bridge\InMemory\AbstractInMemoryLoader;
use Majora\Framework\Loader\Bridge\InMemory\InMemoryLoaderTrait;

/**
 * Image loader implementation using InMemory Orm.
 */
class InMemoryLoader extends AbstractInMemoryLoader implements LoaderInterface
{
    use InMemoryLoaderTrait;
}
