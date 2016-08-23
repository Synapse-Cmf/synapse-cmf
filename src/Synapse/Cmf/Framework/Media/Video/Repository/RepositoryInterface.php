<?php

namespace Synapse\Cmf\Framework\Media\Video\Repository;

use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Majora\Framework\Repository\RepositoryInterface as MajoraRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface for Video persistence use cases.
 */
interface RepositoryInterface extends MajoraRepositoryInterface, EventSubscriberInterface
{
    /**
     * Trigger a persist call into persistence.
     *
     * @param Video $video
     */
    public function save(Video $video);

    /**
     * Trigger a remove call into persistence.
     *
     * @param Video $video
     */
    public function delete(Video $video);
}
