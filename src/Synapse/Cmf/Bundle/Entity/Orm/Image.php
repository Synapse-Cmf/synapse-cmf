<?php

namespace Synapse\Cmf\Bundle\Entity\Orm;

use Majora\Framework\Model\CollectionableTrait;
use Majora\Framework\Model\LazyPropertiesInterface;
use Majora\Framework\Model\LazyPropertiesTrait;
use Majora\Framework\Model\TimedTrait;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImageCollection;
use Synapse\Cmf\Framework\Media\Image\Entity\Image as SynapseImage;

/**
 * Synapse image specific Orm implementation.
 */
class Image extends SynapseImage implements LazyPropertiesInterface
{
    use CollectionableTrait, TimedTrait, LazyPropertiesTrait;

    /**
     * @var string
     */
    protected $assetsWebPath;

    /**
     * Doctrine doesnt hydrate custom collections when loaded
     * so we use collectionnableTrait to always cast FormattedImageCollection.
     *
     * {@inheritdoc}
     */
    public function getFormattedImages()
    {
        return $this->formattedImages = $this->toCollection(
            $this->formattedImages,
            FormattedImageCollection::class
        );
    }

    /**
     * Doctrine needs to cross reference fks.
     *
     * {@inheritdoc}
     */
    public function setFormattedImages(FormattedImageCollection $formattedImages)
    {
        return parent::setFormattedImages($formattedImages->map(function (FormattedImage $formattedImage) {
            return $formattedImage->setImage($this);
        }));
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
