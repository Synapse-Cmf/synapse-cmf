<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Loader;

use Majora\Framework\Loader\LoaderInterface as MajoraLoaderInterface;
use Synapse\Cmf\Framework\Media\File\Model\FileInterface;

/**
 * Interface for FormattedImage loading use cases.
 */
interface LoaderInterface extends MajoraLoaderInterface
{
    /**
     * Retrieve a FormattedFile from a File.
     *
     * @param FileInterface $file
     *
     * @return FormattedFileInterface|null
     */
    public function retrieveByFile(FileInterface $file);
}
