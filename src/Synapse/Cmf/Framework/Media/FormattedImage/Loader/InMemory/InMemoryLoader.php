<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Loader\InMemory;

use Synapse\Cmf\Framework\Media\FormattedImage\Loader\LoaderInterface;
use Majora\Framework\Loader\Bridge\InMemory\AbstractInMemoryLoader;
use Majora\Framework\Loader\Bridge\InMemory\InMemoryLoaderTrait;

/**
 * FormattedImage loader implementation using InMemory Orm.
 */
class InMemoryLoader extends AbstractInMemoryLoader implements LoaderInterface
{
    use InMemoryLoaderTrait;
}
