<?php

namespace Synapse\Cmf\Framework\Media\File\Repository;

use Synapse\Cmf\Framework\Media\File\Entity\File;
use Majora\Framework\Repository\RepositoryInterface as MajoraRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface for File persistence use cases.
 */
interface RepositoryInterface extends MajoraRepositoryInterface, EventSubscriberInterface
{
    /**
     * Trigger a persist call into persistence.
     *
     * @param File $file
     */
    public function save(File $file);

    /**
     * Trigger a remove call into persistence.
     *
     * @param File $file
     */
    public function delete(File $file);
}
