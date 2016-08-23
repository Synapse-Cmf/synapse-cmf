<?php

namespace Synapse\Cmf\Framework\Media\Image\Loader\Doctrine;

use Synapse\Cmf\Framework\Media\Image\Loader\LoaderInterface;
use Majora\Framework\Loader\Bridge\Doctrine\AbstractDoctrineLoader;
use Majora\Framework\Loader\Bridge\Doctrine\DoctrineLoaderTrait;

/**
 * Image loader implementation using Doctrine Orm.
 */
class DoctrineLoader extends AbstractDoctrineLoader implements LoaderInterface
{
    use DoctrineLoaderTrait;
}
