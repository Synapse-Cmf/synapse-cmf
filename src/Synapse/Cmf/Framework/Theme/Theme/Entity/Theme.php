<?php

namespace Synapse\Cmf\Framework\Theme\Theme\Entity;

use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Media\Format\Entity\FormatCollection;
use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateTypeCollection;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;

/**
 * Theme entity class.
 */
class Theme implements ThemeInterface
{
    use NormalizableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $labels;

    /**
     * @var TemplateTypeCollection
     */
    protected $templateTypes;

    /**
     * @var FormatCollection
     */
    protected $imageFormats;

    /**
     * @see NormalizableInterface::getScopes()
     */
    public static function getScopes()
    {
        return array(
            'id' => 'id',
            'default' => array('id'),
        );
    }

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->labels = array();
        $this->templateTypes = new TemplateTypeCollection();
        $this->imageFormats = new FormatCollection();
    }

    /**
     * Returns Theme id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define Theme id.
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
     * Returns Theme name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define Theme name.
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
     * Returns Theme labels.
     *
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Define Theme labels.
     *
     * @param array $labels
     *
     * @return self
     */
    public function setLabels(array $labels)
    {
        $this->labels = $labels;

        return $this;
    }

    /**
     * Returns theme template types.
     *
     * @return TemplateTypeCollection
     */
    public function getTemplateTypes()
    {
        return $this->templateTypes;
    }

    /**
     * Define theme template types.
     *
     * @param TemplateTypeCollection $templateTypes
     *
     * @return self
     */
    public function setTemplateTypes(TemplateTypeCollection $templateTypes)
    {
        $this->templateTypes = $templateTypes;

        return $this;
    }

    /**
     * Returns theme image formats.
     *
     * @return FormatCollection
     */
    public function getImageFormats()
    {
        return $this->imageFormats;
    }

    /**
     * Define theme image formats.
     *
     * @param FormatCollection $imageFormats
     *
     * @return self
     */
    public function setImageFormats(FormatCollection $imageFormats)
    {
        $this->imageFormats = $imageFormats;

        return $this;
    }
}
