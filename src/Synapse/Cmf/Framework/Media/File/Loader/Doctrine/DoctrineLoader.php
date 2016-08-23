<?php

namespace Synapse\Cmf\Framework\Media\File\Loader\Doctrine;

use Synapse\Cmf\Framework\Media\File\Loader\LoaderInterface;
use Majora\Framework\Loader\Bridge\Doctrine\AbstractDoctrineLoader;
use Majora\Framework\Loader\Bridge\Doctrine\DoctrineLoaderTrait;

/**
 * File loader implementation using Doctrine Orm.
 */
class DoctrineLoader extends AbstractDoctrineLoader implements LoaderInterface
{
    use DoctrineLoaderTrait;
}
