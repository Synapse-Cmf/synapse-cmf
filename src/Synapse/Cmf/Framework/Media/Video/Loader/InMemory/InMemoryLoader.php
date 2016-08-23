<?php

namespace Synapse\Cmf\Framework\Media\Video\Loader\InMemory;

use Synapse\Cmf\Framework\Media\Video\Loader\LoaderInterface;
use Majora\Framework\Loader\Bridge\InMemory\AbstractInMemoryLoader;
use Majora\Framework\Loader\Bridge\InMemory\InMemoryLoaderTrait;

/**
 * Video loader implementation using InMemory Orm.
 */
class InMemoryLoader extends AbstractInMemoryLoader implements LoaderInterface
{
    use InMemoryLoaderTrait;
}
