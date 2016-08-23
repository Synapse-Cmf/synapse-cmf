<?php

namespace Synapse\Cmf\Framework\Media\Media\Domain;

use Symfony\Component\HttpFoundation\File\File as PhysicalFile;

/**
 * Interface for Media domain use cases.
 */
interface DomainInterface
{
    /**
     * Trigger media creation through uploaded file.
     *
     * @param PhysicalFile $file
     * @param string       $name optionnal media name to init with
     *
     * @return File
     */
    public function upload(PhysicalFile $file, $name = null);

    /**
     * Trigger media creation through a file already hosted on server.
     *
     * @param PhysicalFile $file
     * @param string       $name optionnal media name to init with
     *
     * @return File
     */
    public function create(PhysicalFile $file, $name = null);
}
