<?php

namespace Synapse\Cmf\Framework\Media\Video\Loader\Doctrine;

use Synapse\Cmf\Framework\Media\Video\Loader\LoaderInterface;
use Majora\Framework\Loader\Bridge\Doctrine\AbstractDoctrineLoader;
use Majora\Framework\Loader\Bridge\Doctrine\DoctrineLoaderTrait;

/**
 * Video loader implementation using Doctrine Orm.
 */
class DoctrineLoader extends AbstractDoctrineLoader implements LoaderInterface
{
    use DoctrineLoaderTrait;
}
