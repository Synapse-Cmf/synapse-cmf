<?php

namespace Synapse\Cmf\Bundle\Loader\Orm;

use Majora\Framework\Loader\LazyLoaderInterface;
use Synapse\Cmf\Bundle\Entity\Orm\FormattedImage;
use Synapse\Cmf\Framework\Media\Format\Loader\LoaderInterface as FormatLoader;
use Synapse\Cmf\Framework\Media\FormattedImage\Loader\Doctrine\DoctrineLoader as SynapseFormattedImageDoctrineLoader;

/**
 * FormattedImage loader override to register lazy loaders.
 */
class FormattedImageOrmLoader extends SynapseFormattedImageDoctrineLoader implements LazyLoaderInterface
{
    /**
     * @var FormatLoader
     */
    protected $formatLoader;

    /**
     * @var string
     */
    protected $assetsWebPath;

    /**
     * Construct.
     *
     * @param FormatLoader $formatLoader
     * @param string       $assetsWebPath
     */
    public function __construct(FormatLoader $formatLoader, $assetsWebPath)
    {
        $this->formatLoader = $formatLoader;
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
            'format' => function (FormattedImage $formattedImage) {
                return $this->formatLoader->retrieveOne(array(
                    'name' => $formattedImage->getFormatId(),
                ));
            },
        );
    }
}
