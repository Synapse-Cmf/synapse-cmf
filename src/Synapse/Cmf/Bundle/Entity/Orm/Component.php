<?php

namespace Synapse\Cmf\Bundle\Entity\Orm;

use Majora\Framework\Model\CollectionableTrait;
use Majora\Framework\Model\LazyPropertiesInterface;
use Majora\Framework\Model\LazyPropertiesTrait;
use Majora\Framework\Model\TimedTrait;
use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component as SynapseComponent;

/**
 * Synapse component specific Orm implementation.
 */
class Component extends SynapseComponent implements LazyPropertiesInterface
{
    use CollectionableTrait, TimedTrait, LazyPropertiesTrait;

    /**
     * @var string
     */
    protected $componentTypeId;

    /**
     * Only registered for Doctrine fk,
     * never get a Zone from a component.
     *
     * @var Zone
     */
    private $zone;

    /**
     * @see NormalizableInterface::getScopes()
     */
    public static function getScopes()
    {
        return array_replace(
            parent::getScopes(),
            array('template' => array(
                'component_id', 'component_type@id', 'ranking',
            ))
        );
    }

    /**
     * Returns component template id.
     *
     * @return string
     */
    public function getComponentId()
    {
        return sprintf('%s_%s',
            $this->getComponentType()->getName(),
            $this->getId()
        );
    }

    /**
     * Override to trigger lazy loading.
     *
     * {@inheritdoc}
     */
    public function getComponentType()
    {
        return $this->load('componentType');
    }

    /**
     * Override to store database required fields data.
     *
     * {@inheritdoc}
     */
    public function setComponentType(ComponentTypeInterface $componentType)
    {
        $this->componentTypeId = $componentType->getId();

        return parent::setComponentType($componentType);
    }

    /**
     * Define object zone.
     *
     * @param Zone $zone
     *
     * @return self
     */
    public function setZone(Zone $zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Returns object component type id.
     *
     * @return string
     */
    public function getComponentTypeId()
    {
        return $this->componentTypeId;
    }
}
