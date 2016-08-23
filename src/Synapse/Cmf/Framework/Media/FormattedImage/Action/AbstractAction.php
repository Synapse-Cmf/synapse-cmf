<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Action;

use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Model\FormattedImageInterface;
use Majora\Framework\Domain\Action\AbstractAction as MajoraAbstractAction;

/**
 * Base class for FormattedImage Actions.
 *
 * @property $formattedImage
 */
abstract class AbstractAction extends MajoraAbstractAction
{
    /**
     * @var FormattedImageInterface
     */
    protected $formattedImage;

    /**
     * Initialisation function.
     *
     * @param FormattedImageInterface $formattedImage
     */
    public function init(FormattedImageInterface $formattedImage = null)
    {
        $this->formattedImage = $formattedImage;

        return $this;
    }

    /**
     * Return related FormattedImage if defined.
     *
     * @return FormattedImageInterface|null $formattedImage
     */
    public function getFormattedImage()
    {
        return $this->formattedImage;
    }
}
