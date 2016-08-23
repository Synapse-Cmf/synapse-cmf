<?php

namespace Synapse\Cmf\Framework\Media\Image\Action\Dal;

use Synapse\Cmf\Framework\Media\Image\Event\Event as ImageEvent;
use Synapse\Cmf\Framework\Media\Image\Event\Events as ImageEvents;
use Majora\Framework\Domain\Action\DynamicActionTrait;

/**
 * Image deletion action representation.
 */
class DeleteAction extends AbstractDalAction
{
    use DynamicActionTrait;

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->fireEvent(
            ImageEvents::IMAGE_DELETED,
            new ImageEvent($this->image, $this)
        );
    }
}
