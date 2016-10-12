<?php

namespace Synapse\Cmf\Framework\Theme\ZoneType\Entity;

use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentTypeCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Model\ZoneTypeInterface;

/**
 * ZoneType entity class.
 */
class ZoneType implements ZoneTypeInterface
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
     * @var ComponentTypeCollection
     */
    protected $allowedComponentTypes;

    /**
     * @var int
     */
    protected $order;

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
        $this->allowedComponentTypes = new ComponentTypeCollection();
    }

    /**
     * Returns ZoneType id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define ZoneType id.
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
     * Returns ZoneType name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define ZoneType name.
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
     * Returns ZoneType allowed component types.
     *
     * @return ComponentTypeCollection
     */
    public function getAllowedComponentTypes()
    {
        return $this->allowedComponentTypes;
    }

    /**
     * Define ZoneType allowed component types.
     *
     * @param ComponentTypeCollection $allowedComponentTypes
     *
     * @return self
     */
    public function setAllowedComponentTypes(ComponentTypeCollection $allowedComponentTypes)
    {
        $this->allowedComponentTypes = $allowedComponentTypes;

        return $this;
    }

    /**
     * Returns ZoneType labels.
     *
     * @return array
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Define ZoneType labels.
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
     * Returns ZoneType order.
     *
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Define ZoneType order.
     *
     * @param int $order
     *
     * @return self
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }
}
