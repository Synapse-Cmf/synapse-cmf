<?php

namespace Synapse\Cmf\Bundle\Loader\Orm;

use Majora\Framework\Loader\LazyLoaderInterface;
use Synapse\Cmf\Bundle\Entity\Orm\Image;
use Synapse\Cmf\Framework\Media\Image\Loader\Doctrine\DoctrineLoader as SynapseImageOrmLoader;

/**
 * Image loader override to register lazy loaders.
 */
class ImageOrmLoader extends SynapseImageOrmLoader implements LazyLoaderInterface
{
    /**
     * @var string
     */
    protected $assetsWebPath;

    /**
     * Construct.
     *
     * @param string $assetsWebPath
     */
    public function __construct($assetsWebPath)
    {
        $this->assetsWebPath = $assetsWebPath;
    }

    /**
     * @see LazyLoaderInterface::getLoadingDelegates()
     */
    public function getLoadingDelegates()
    {
        return array(
            'assetsWebPath' => function () {
                return $this->assetsWebPath;
            },
        );
    }
}
