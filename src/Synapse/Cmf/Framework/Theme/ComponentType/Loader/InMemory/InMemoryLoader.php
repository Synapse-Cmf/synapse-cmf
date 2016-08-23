<?php

namespace Synapse\Cmf\Framework\Theme\ComponentType\Loader\InMemory;

use Majora\Framework\Loader\Bridge\InMemory\InMemoryLoaderTrait;
use Majora\Framework\Loader\Bridge\InMemory\AbstractInMemoryLoader;
use Synapse\Cmf\Framework\Theme\ComponentType\Loader\LoaderInterface;

/**
 * ComponentType loader implementation using server memory.
 */
class InMemoryLoader extends AbstractInMemoryLoader implements LoaderInterface
{
    use InMemoryLoaderTrait;
}
