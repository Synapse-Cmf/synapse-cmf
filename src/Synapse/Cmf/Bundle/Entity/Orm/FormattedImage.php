<?php

namespace Synapse\Cmf\Bundle\Entity\Orm;

use Majora\Framework\Model\CollectionableTrait;
use Majora\Framework\Model\LazyPropertiesInterface;
use Majora\Framework\Model\LazyPropertiesTrait;
use Majora\Framework\Model\TimedTrait;
use Synapse\Cmf\Framework\Media\Format\Model\FormatInterface;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage as SynapseFormattedImage;

/**
 * Synapse formatted image specific Orm implementation.
 */
class FormattedImage extends SynapseFormattedImage implements LazyPropertiesInterface
{
    use CollectionableTrait, TimedTrait, LazyPropertiesTrait;

    /**
     * @var string
     */
    protected $formatId;

    /**
     * @var string
     */
    protected $assetsWebPath;

    /**
     * Only registered for Doctrine fk,
     * never get an Image from a FormattedImage.
     *
     * @var Image
     */
    private $image;

    /**
     * Override to trigger lazy loading.
     *
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return $this->load('format');
    }

    /**
     * Override to store database required fields data.
     *
     * {@inheritdoc}
     */
    public function setFormat(FormatInterface $format)
    {
        $this->formatId = $format->getName();

        return parent::setFormat($format);
    }

    /**
     * Required by Doctrine to hydrate crossed references.
     *
     * @param Image $image
     *
     * @return self
     */
    public function setImage(Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Returns object format id.
     *
     * @return string
     */
    public function getFormatId()
    {
        return $this->formatId;
    }

    /**
     * Return Media web path.
     *
     * @return string
     */
    public function getWebPath()
    {
        return sprintf('%s%s%s',
            $this->load('assetsWebPath'),
            $this->file->getStorePath(),
            $this->file->getName()
        );
    }
}
