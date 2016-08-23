<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Domain\Action;

use Majora\Framework\Domain\ActionDispatcherDomain as MajoraActionDispatcherDomain;
use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Model\ZoneTypeInterface;
use Synapse\Cmf\Framework\Theme\Zone\Domain\DomainInterface;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Zone domain use cases class.
 */
class ActionDispatcherDomain extends MajoraActionDispatcherDomain implements DomainInterface
{
    /**
     * @see DomainInterface::create()
     */
    public function create(ZoneTypeInterface $zoneType, ComponentCollection $components = null)
    {
        return $this->getAction('create')
            ->setZoneType($zoneType)
            ->setComponents($components ?: new ComponentCollection())
            ->resolve()
        ;
    }

    /**
     * @see DomainInterface::addComponent()
     */
    public function addComponent(ZoneInterface $zone, ComponentTypeInterface $componentType)
    {
        return $this->getAction('add_component', $zone)
            ->setComponentType($componentType)
            ->resolve()
        ;
    }

    /**
     * @see DomainInterface::edit()
     */
    public function edit(ZoneInterface $zone, ...$arguments)
    {
        return $this->getAction('edit', $zone, ...$arguments)
            ->resolve()
        ;
    }

    /**
     * @see DomainInterface::delete()
     */
    public function delete(ZoneInterface $zone, ...$arguments)
    {
        return $this->getAction('delete', $zone, ...$arguments)
            ->resolve()
        ;
    }
}
