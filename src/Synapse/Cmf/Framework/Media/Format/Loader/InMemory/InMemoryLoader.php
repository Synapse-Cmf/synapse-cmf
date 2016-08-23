<?php

namespace Synapse\Cmf\Framework\Media\Format\Loader\InMemory;

use Synapse\Cmf\Framework\Media\Format\Loader\LoaderInterface;
use Majora\Framework\Loader\Bridge\InMemory\AbstractInMemoryLoader;
use Majora\Framework\Loader\Bridge\InMemory\InMemoryLoaderTrait;

/**
 * Format loader implementation using InMemory Orm.
 */
class InMemoryLoader extends AbstractInMemoryLoader implements LoaderInterface
{
    use InMemoryLoaderTrait;
}
