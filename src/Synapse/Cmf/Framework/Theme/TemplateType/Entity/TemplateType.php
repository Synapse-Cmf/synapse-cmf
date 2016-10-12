<?php

namespace Synapse\Cmf\Framework\Theme\TemplateType\Entity;

use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Theme\TemplateType\Model\TemplateTypeInterface;
use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneTypeCollection;

/**
 * TemplateType entity class.
 */
class TemplateType implements TemplateTypeInterface
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
     * @var ZoneTypeCollection
     */
    protected $zoneTypes;

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
        $this->zoneTypes = new ZoneTypeCollection();
    }

    /**
     * Returns TemplateType id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define TemplateType id.
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
     * Returns TemplateType name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define TemplateType name.
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
     * Returns TemplateType labels.
     *
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Define TemplateType labels.
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
     * Returns TemplateType zone types.
     *
     * @return ZoneTypeCollection
     */
    public function getZoneTypes()
    {
        return $this->zoneTypes;
    }

    /**
     * Define TemplateType zone types.
     *
     * @param ZoneTypeCollection $zoneTypes
     *
     * @return self
     */
    public function setZoneTypes(ZoneTypeCollection $zoneTypes)
    {
        $this->zoneTypes = $zoneTypes;

        return $this;
    }

    /**
     * Tests if this TemplateType supports given content type from given content types list.
     *
     * @param string $contentType
     * @param array  $contentTypes
     *
     * @return bool
     */
    public function supportsContentType($contentType, array $contentTypes)
    {
        return empty($contentTypes)
            || in_array($contentType, $contentTypes)
        ;
    }
}
