<?php

namespace Synapse\Cmf\Bundle\Loader\Orm;

use Majora\Framework\Loader\LazyLoaderInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File as PhysicalFile;
use Synapse\Cmf\Bundle\Entity\Orm\File;
use Synapse\Cmf\Framework\Media\File\Loader\Doctrine\DoctrineLoader as SynapseFileDoctrineLoader;

/**
 * File loader override to register lazy loaders.
 */
class FileOrmLoader extends SynapseFileDoctrineLoader implements LazyLoaderInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $storePath;

    /**
     * Construct.
     *
     * @param Filesystem $filesystem
     * @param string     $storePath
     */
    public function __construct(Filesystem $filesystem, $storePath)
    {
        $this->filesystem = $filesystem;
        $this->storePath = $storePath;
    }

    /**
     * @see LazyLoaderInterface::getLoadingDelegates()
     */
    public function getLoadingDelegates()
    {
        return array(
            'physicalFile' => function (File $file) {
                $filePath = sprintf('%s/%s/%s',
                    $this->storePath,
                    $file->getStorePath(),
                    $file->getName()
                );

                return $this->filesystem->exists($filePath)
                    ? new PhysicalFile($filePath)
                    : null
                ;
            },
        );
    }
}
