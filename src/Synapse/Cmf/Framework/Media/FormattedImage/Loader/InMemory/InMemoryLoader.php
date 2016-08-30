<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Loader\InMemory;

use Synapse\Cmf\Framework\Media\File\Model\FileInterface;
use Synapse\Cmf\Framework\Media\FormattedImage\Loader\FormattedFileInterface;
use Synapse\Cmf\Framework\Media\FormattedImage\Loader\LoaderInterface;
use Majora\Framework\Loader\Bridge\InMemory\AbstractInMemoryLoader;
use Majora\Framework\Loader\Bridge\InMemory\InMemoryLoaderTrait;

/**
 * FormattedImage loader implementation using InMemory Orm.
 */
class InMemoryLoader extends AbstractInMemoryLoader implements LoaderInterface
{
    use InMemoryLoaderTrait;

    /**
     * Retrieve a FormattedFile from a File.
     *
     * @param FileInterface $file
     *
     * @return FormattedFileInterface|null
     */
    public function retrieveByFile(FileInterface $file)
    {
        throw new \DomainException('method not implemented yet');
    }
}
