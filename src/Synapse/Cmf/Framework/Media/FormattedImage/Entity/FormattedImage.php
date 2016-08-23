<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Entity;

use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Media\Format\Model\FormatInterface;
use Synapse\Cmf\Framework\Media\FormattedImage\Model\FormattedImageInterface;
use Synapse\Cmf\Framework\Media\Media\Entity\Media;

/**
 * FormattedImage entity class.
 */
class FormattedImage extends Media implements FormattedImageInterface
{
    use NormalizableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var FormatInterface
     */
    protected $format;

    /**
     * @var array
     */
    protected $origin;

    /**
     * @see NormalizableInterface::getScopes()
     */
    public static function getScopes()
    {
        return array(
            'id' => 'id',
            'default' => array('id', 'format', 'webPath'),
        );
    }

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->origin = array('x' => 0, 'y' => 0);
    }

    /**
     * Returns FormattedImage id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define FormattedImage id.
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
     * Returns FormattedImage format.
     *
     * @return FormatInterface
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Define FormattedImage format.
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
     * Returns FormattedImage origin.
     *
     * @return array
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Define FormattedImage origin.
     *
     * @param array $origin
     *
     * @return self
     */
    public function setOrigin(array $origin)
    {
        $this->origin = array_replace(
            $this->origin,
            array_intersect_key($origin, $this->origin)
        );

        return $this;
    }
}
