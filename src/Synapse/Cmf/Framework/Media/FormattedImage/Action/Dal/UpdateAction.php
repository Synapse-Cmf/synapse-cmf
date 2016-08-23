<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Action\Dal;

use Synapse\Cmf\Framework\Media\FormattedImage\Event\Event as FormattedImageEvent;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Events as FormattedImageEvents;
use Majora\Framework\Domain\Action\DynamicActionTrait;

/**
 * FormattedImage edition action representation.
 */
class UpdateAction extends AbstractDalAction
{
    use DynamicActionTrait;

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->formattedImage->denormalize($this->normalize('update'));

        $this->assertEntityIsValid($this->formattedImage, array('FormattedImage', 'edition'));

        $this->fireEvent(
            FormattedImageEvents::FORMATTED_IMAGE_EDITED,
            new FormattedImageEvent($this->formattedImage, $this)
        );
    }
}
