<?php

namespace Synapse\Cmf\Framework\Media\Format\Entity;

use Synapse\Cmf\Framework\Media\Format\Model\FormatInterface;
use Majora\Framework\Model\CollectionableTrait;
use Majora\Framework\Normalizer\Model\NormalizableTrait;

/**
 * Format entity class.
 */
class Format implements FormatInterface
{
    use CollectionableTrait, NormalizableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $strategy;

    /**
     * @var string
     */
    protected $width;

    /**
     * @var string
     */
    protected $height;

    /**
     * @see NormalizableInterface::getScopes()
     */
    public static function getScopes()
    {
        return array(
            'id' => 'id',
            'default' => array('id', 'name', 'strategy', 'width', 'height'),
        );
    }

    /**
     * Returns Format id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define Format id.
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
     * Returns object name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define object name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns object strategy.
     *
     * @return string
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * Define object strategy.
     *
     * @param string $strategy
     *
     * @return self
     */
    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;

        return $this;
    }

    /**
     * Returns object width.
     *
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Define object width.
     *
     * @param string $width
     *
     * @return self
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Returns object height.
     *
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Define object height.
     *
     * @param string $height
     *
     * @return self
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }
}
