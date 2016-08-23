<?php

namespace Synapse\Cmf\Framework\Theme\Component\Loader\Doctrine;

use Synapse\Cmf\Framework\Theme\Component\Loader\LoaderInterface;
use Majora\Framework\Loader\Bridge\Doctrine\AbstractDoctrineLoader;
use Majora\Framework\Loader\Bridge\Doctrine\DoctrineLoaderTrait;

/**
 * Component loader implementation using Doctrine Orm.
 */
class DoctrineLoader extends AbstractDoctrineLoader implements LoaderInterface
{
    use DoctrineLoaderTrait;
}
