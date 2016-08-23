<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Repository;

use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Majora\Framework\Repository\RepositoryInterface as MajoraRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface for FormattedImage persistence use cases.
 */
interface RepositoryInterface extends MajoraRepositoryInterface, EventSubscriberInterface
{
    /**
     * Trigger a persist call into persistence.
     *
     * @param FormattedImage $formattedImage
     */
    public function save(FormattedImage $formattedImage);

    /**
     * Trigger a remove call into persistence.
     *
     * @param FormattedImage $formattedImage
     */
    public function delete(FormattedImage $formattedImage);
}
