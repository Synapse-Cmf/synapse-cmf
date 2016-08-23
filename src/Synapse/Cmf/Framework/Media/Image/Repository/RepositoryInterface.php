<?php

namespace Synapse\Cmf\Framework\Media\Image\Repository;

use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Majora\Framework\Repository\RepositoryInterface as MajoraRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface for Image persistence use cases.
 */
interface RepositoryInterface extends MajoraRepositoryInterface, EventSubscriberInterface
{
    /**
     * Trigger a persist call into persistence.
     *
     * @param Image $image
     */
    public function save(Image $image);

    /**
     * Trigger a remove call into persistence.
     *
     * @param Image $image
     */
    public function delete(Image $image);
}
