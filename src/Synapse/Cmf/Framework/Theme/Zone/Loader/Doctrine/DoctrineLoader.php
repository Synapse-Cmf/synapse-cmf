<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Loader\Doctrine;

use Synapse\Cmf\Framework\Theme\Zone\Loader\LoaderInterface;
use Majora\Framework\Loader\Bridge\Doctrine\AbstractDoctrineLoader;
use Majora\Framework\Loader\Bridge\Doctrine\DoctrineLoaderTrait;

/**
 * Zone loader implementation using Doctrine Orm.
 */
class DoctrineLoader extends AbstractDoctrineLoader implements LoaderInterface
{
    use DoctrineLoaderTrait;
}
