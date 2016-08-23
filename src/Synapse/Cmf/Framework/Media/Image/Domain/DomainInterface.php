<?php

namespace Synapse\Cmf\Framework\Media\Image\Domain;

use Synapse\Cmf\Framework\Media\Image\Model\ImageInterface;
use Synapse\Cmf\Framework\Media\Media\Domain\DomainInterface as MediaDomainInterface;

/**
 * Interface for Image domain use cases.
 */
interface DomainInterface extends MediaDomainInterface
{
    /**
     * Create and returns an action for delete a Image.
     *
     * @param ImageInterface $image
     *
     * @return DeleteImageAction
     */
    public function delete(ImageInterface $image);
}
