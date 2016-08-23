<?php

namespace Synapse\Cmf\Framework\Media\File\Loader\InMemory;

use Synapse\Cmf\Framework\Media\File\Loader\LoaderInterface;
use Majora\Framework\Loader\Bridge\InMemory\AbstractInMemoryLoader;
use Majora\Framework\Loader\Bridge\InMemory\InMemoryLoaderTrait;

/**
 * File loader implementation using InMemory Orm.
 */
class InMemoryLoader extends AbstractInMemoryLoader implements LoaderInterface
{
    use InMemoryLoaderTrait;
}
