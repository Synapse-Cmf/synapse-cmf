<?php

namespace Synapse\Cmf\Framework\Media\Image\Entity;

use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Media\Format\Model\FormatInterface;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImageCollection;
use Synapse\Cmf\Framework\Media\FormattedImage\Model\FormattedImageInterface;
use Synapse\Cmf\Framework\Media\Image\Model\ImageInterface;
use Synapse\Cmf\Framework\Media\Media\Entity\Media;

/**
 * Image entity class.
 */
class Image extends Media implements ImageInterface
{
    use NormalizableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * Override and immutable type, image are always type "image".
     *
     * @var string
     */
    protected $type = 'image';

    /**
     * @var array
     */
    protected $tags;

    /**
     * @var string
     */
    protected $headline;

    /**
     * @var string
     */
    protected $alt;

    /**
     * @var FormattedImageCollection
     */
    protected $formattedImages;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->tags = array();
        $this->formattedImages = new FormattedImageCollection();
    }

    /**
     * @see NormalizableInterface::getScopes()
     */
    public static function getScopes()
    {
        return array(
            'id' => 'id',
            'default' => array('id', 'type'),
        );
    }

    /**
     * Returns Image id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define Image id.
     *
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns image tags.
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Define image tags.
     *
     * @param array $tags
     *
     * @return self
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Returns image headline.
     *
     * @return string
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Define image headline.
     *
     * @param string $headline
     *
     * @return self
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * Returns image alt.
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Define image alt.
     *
     * @param string $alt
     *
     * @return self
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Returns image formatted images.
     *
     * @return FormattedImageCollection
     */
    public function getFormattedImages()
    {
        return $this->formattedImages;
    }

    /**
     * Returns image formatted for given format name or FormatInterface object.
     *
     * @param string|FormatInterface $format
     *
     * @return FormattedImageInterface|null
     */
    public function getFormattedImage($format)
    {
        $formatName = $format instanceof FormatInterface
            ? $format->getName()
            : $format
        ;

        return $this->formattedImages
            ->filter(function (FormattedImageInterface $formattedImage) use ($formatName) {
                return ($format = $formattedImage->getFormat())
                    && $format->getName() == $formatName
                ;
            })
            ->first() ?: null // first() returns "false" if collection empty
        ;
    }

    /**
     * Returns requested format web path, or original one, if format doesnt exists.
     *
     * @param string|FormatInterface $format
     *
     * @return string
     */
    public function getFormatWebPath($format)
    {
        return ($formattedImage = $this->getFormattedImage($format))
            ? $formattedImage->getWebPath()
            : $this->getWebPath()
        ;
    }

    /**
     * Define image formatted images.
     *
     * @param FormattedImageCollection $formattedImages
     *
     * @return self
     */
    public function setFormattedImages(FormattedImageCollection $formattedImages)
    {
        $this->formattedImages = $formattedImages;

        return $this;
    }

    /**
     * Returns image type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
