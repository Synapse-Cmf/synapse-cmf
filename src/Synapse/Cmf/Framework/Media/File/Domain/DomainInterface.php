<?php

namespace Synapse\Cmf\Framework\Media\File\Domain;

use Symfony\Component\HttpFoundation\File\File as PhysicalFile;

/**
 * Interface for File domain use cases.
 */
interface DomainInterface
{
    /**
     * Trigger file creation through uploaded file.
     *
     * @param PhysicalFile $file
     *
     * @return File
     */
    public function upload(PhysicalFile $file);

    /**
     * Create and returns an action for create a File.
     *
     * @return CreateFileAction
     */
    public function create(PhysicalFile $file);
}
