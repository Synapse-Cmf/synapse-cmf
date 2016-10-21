<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Domain;

use Majora\Framework\Domain\ActionDispatcherDomain;
use Majora\Framework\Domain\Action\ActionFactory;
use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\ZoneType\Model\ZoneTypeInterface;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Zone domain use cases class.
 */
class ZoneDomain extends ActionDispatcherDomain implements DomainInterface
{
    /**
     * @var ActionFactory
     */
    protected $commandFactory;

    /**
     * Construct.
     *
     * @param ActionFactory $commandFactory
     */
    public function __construct(ActionFactory $commandFactory)
    {
        $this->commandFactory = $commandFactory;

        parent::__construct($commandFactory); // backward compatibility
    }

    /**
     * @see DomainInterface::create()
     */
    public function create(ZoneTypeInterface $zoneType, ComponentCollection $components = null)
    {
        return $this->commandFactory
            ->createAction('create')
                ->setZoneType($zoneType)
                ->setComponents($components ?: new ComponentCollection())
            ->resolve()
        ;
    }

    /**
     * @see DomainInterface::edit()
     */
    public function edit(ZoneInterface $zone, ComponentCollection $components)
    {
        return $this->commandFactory
            ->createAction('edit')
                ->init($zone)
                ->setComponents($components)
            ->resolve()
        ;
    }

    /**
     * @see DomainInterface::addComponent()
     */
    public function addComponent(ZoneInterface $zone, ComponentTypeInterface $componentType, array $componentData = array())
    {
        return $this->commandFactory
            ->createAction('add_component')
                ->init($zone)
                ->setComponentType($componentType)
                ->setComponentData($componentData)
            ->resolve()
        ;
    }
}
