<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Entity;

use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Model\ZoneTypeInterface;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Zone entity class.
 */
class Zone implements ZoneInterface
{
    use NormalizableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var ZoneTypeInterface
     */
    protected $zoneType;

    /**
     * @var ComponentCollection
     */
    protected $components;

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
        $this->components = new ComponentCollection();
    }

    /**
     * Returns Zone id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define Zone id.
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
     * Returns object zone type.
     *
     * @return ZoneTypeInterface
     */
    public function getZoneType()
    {
        return $this->zoneType;
    }

    /**
     * Define object zone type.
     *
     * @param ZoneTypeInterface $zoneType
     *
     * @return self
     */
    public function setZoneType(ZoneTypeInterface $zoneType)
    {
        $this->zoneType = $zoneType;

        return $this;
    }

    /**
     * Returns object components.
     *
     * @return ComponentCollection
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * Define object components.
     *
     * @param ComponentCollection $components
     *
     * @return self
     */
    public function setComponents(ComponentCollection $components)
    {
        $this->components = $components;

        return $this;
    }
}
