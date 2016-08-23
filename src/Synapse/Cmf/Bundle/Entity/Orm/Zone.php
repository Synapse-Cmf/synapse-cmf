<?php

namespace Synapse\Cmf\Bundle\Entity\Orm;

use Majora\Framework\Model\CollectionableTrait;
use Majora\Framework\Model\LazyPropertiesInterface;
use Majora\Framework\Model\LazyPropertiesTrait;
use Majora\Framework\Model\TimedTrait;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection as SynapseComponentCollection;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Model\ZoneTypeInterface;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone as SynapseZone;

/**
 * Synapse zone specific Orm implementation.
 */
class Zone extends SynapseZone implements LazyPropertiesInterface
{
    use CollectionableTrait, TimedTrait, LazyPropertiesTrait;

    /**
     * @var string
     */
    protected $zoneTypeId;

    /**
     * Only registered for Doctrine fk,
     * never get a Template from a zone.
     *
     * @var Template
     */
    private $template;

    /**
     * Override to trigger lazy loading.
     *
     * {@inheritdoc}
     */
    public function getZoneType()
    {
        return $this->load('zoneType');
    }

    /**
     * Override to store database required fields data.
     *
     * {@inheritdoc}
     */
    public function setZoneType(ZoneTypeInterface $zoneType)
    {
        $this->zoneTypeId = $zoneType->getId();

        return parent::setZoneType($zoneType);
    }

    /**
     * Doctrine doesnt hydrate custom collections when loaded
     * so we use collectionnableTrait to always cast ZoneCollection.
     *
     * {@inheritdoc}
     */
    public function getComponents()
    {
        return $this->components = $this->toCollection(
            $this->components,
            SynapseComponentCollection::class
        );
    }

    /**
     * Doctrine needs to cross reference fks.
     *
     * {@inheritdoc}
     */
    public function setComponents(ComponentCollection $components)
    {
        return parent::setComponents($components->map(function (Component $component) {
            return $component->setZone($this);
        }));
    }

    /**
     * Returns Zone zone type id.
     *
     * @return string
     */
    public function getZoneTypeId()
    {
        return $this->zoneTypeId;
    }

    /**
     * Returns object template.
     *
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Define object template.
     *
     * @param Template $template
     *
     * @return self
     */
    public function setTemplate(Template $template)
    {
        $this->template = $template;

        return $this;
    }
}
