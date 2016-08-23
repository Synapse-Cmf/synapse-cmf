<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Action\Dal;

use Synapse\Cmf\Framework\Media\FormattedImage\Event\Event as FormattedImageEvent;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Events as FormattedImageEvents;
use Majora\Framework\Domain\Action\DynamicActionTrait;

/**
 * FormattedImage deletion action representation.
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
            FormattedImageEvents::FORMATTED_IMAGE_DELETED,
            new FormattedImageEvent($this->formattedImage, $this)
        );
    }
}
