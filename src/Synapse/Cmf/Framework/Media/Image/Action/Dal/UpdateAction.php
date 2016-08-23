<?php

namespace Synapse\Cmf\Framework\Media\Image\Action\Dal;

use Synapse\Cmf\Framework\Media\Image\Event\Event as ImageEvent;
use Synapse\Cmf\Framework\Media\Image\Event\Events as ImageEvents;
use Synapse\Cmf\Framework\Media\Image\Model\ImageInterface;

/**
 * Image edition action representation.
 */
class UpdateAction extends AbstractDalAction
{
    /**
     * {@inheritdoc}
     */
    public function init(ImageInterface $image = null)
    {
        if (!$image) {
            return $this;
        }

        $this->image = $image;

        return $this
            ->setName($image->getName())
            ->setTitle($image->getTitle())
            ->setHeadline($image->getHeadline())
            ->setAlt($image->getAlt())
            ->setExternalLink($image->getExternalLink())
            ->setTags(implode(', ', $image->getTags()))
        ;
    }

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->image
            ->setName($this->getName())
            ->setTitle($this->getTitle())
            ->setHeadline($this->getHeadline())
            ->setAlt($this->getAlt())
            ->setExternalLink($this->getExternalLink())
            ->setTags(explode(', ', trim($this->getTags())))
        ;

        $this->assertEntityIsValid($this->image, array('Image', 'edition'));

        $this->fireEvent(
            ImageEvents::IMAGE_EDITED,
            new ImageEvent($this->image, $this)
        );

        return $this->image;
    }
}
