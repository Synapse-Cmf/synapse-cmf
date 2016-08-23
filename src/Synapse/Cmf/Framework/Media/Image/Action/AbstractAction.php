<?php

namespace Synapse\Cmf\Framework\Media\Image\Action;

use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Synapse\Cmf\Framework\Media\Image\Model\ImageInterface;
use Majora\Framework\Domain\Action\AbstractAction as MajoraAbstractAction;

/**
 * Base class for Image Actions.
 *
 * @property $image
 */
abstract class AbstractAction extends MajoraAbstractAction
{
    /**
     * @var ImageInterface
     */
    protected $image;

    /**
     * Initialisation function.
     *
     * @param ImageInterface $image
     */
    public function init(ImageInterface $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Return related Image if defined.
     *
     * @return ImageInterface|null $image
     */
    public function getImage()
    {
        return $this->image;
    }
}
