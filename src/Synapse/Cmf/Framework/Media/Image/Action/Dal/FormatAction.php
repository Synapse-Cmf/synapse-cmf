<?php

namespace Synapse\Cmf\Framework\Media\Image\Action\Dal;

use Synapse\Cmf\Framework\Media\Image\Event\Event as ImageEvent;
use Synapse\Cmf\Framework\Media\Image\Event\Events as ImageEvents;
use Synapse\Cmf\Framework\Media\Format\Model\FormatInterface;
use Synapse\Cmf\Framework\Media\FormattedImage\Domain\DomainInterface as FormattedImageDomain;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormatOptions;

/**
 * Image formatting action, trigger new FormattedImage creation.
 */
class FormatAction extends AbstractDalAction
{
    /**
     * @var FormattedImageDomain
     */
    protected $formattedImageDomain;

    /**
     * @var FormatInterface
     */
    protected $format;

    /**
     * @var FormatOptions
     */
    protected $options;

    /**
     * Construct.
     *
     * @param FormattedImageDomain $formattedImageDomain
     */
    public function __construct(FormattedImageDomain $formattedImageDomain)
    {
        $this->formattedImageDomain = $formattedImageDomain;
    }

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $formattedImageCollection = $this->image->getFormattedImages();
        $formattedImageCollection->add(
            $this->formattedImageDomain->create(
                $this->image->getFile(),
                $this->getFormat(),
                $this->getOptions()
            )
        );

        $this->image->setFormattedImages($formattedImageCollection);

        $this->assertEntityIsValid($this->image, array('Image', 'edition'));

        $this->fireEvent(
            ImageEvents::IMAGE_EDITED,
            new ImageEvent($this->image, $this)
        );

        return $this->image;
    }

    /**
     * Returns action format.
     *
     * @return FormatInterface
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Define action format.
     *
     * @param FormatInterface $format
     *
     * @return self
     */
    public function setFormat(FormatInterface $format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Returns action options.
     *
     * @return FormatOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Define action options.
     *
     * @param FormatOptions $options
     *
     * @return self
     */
    public function setOptions(FormatOptions $options)
    {
        $this->options = $options;

        return $this;
    }
}
