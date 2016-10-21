<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Domain\Command;

use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Domain\DomainInterface as ComponentDomain;

/**
 * Zone add component command representation.
 */
class AddComponentCommand extends UpdateCommand
{
    /**
     * @var ComponentTypeInterface
     */
    protected $componentType;

    /**
     * @var array
     */
    protected $componentData;

    /**
     * @var ComponentDomain
     */
    protected $componentDomain;

    /**
     * Construct.
     *
     * @param ComponentDomain $componentDomain
     */
    public function __construct(ComponentDomain $componentDomain)
    {
        $this->componentDomain = $componentDomain;
        $this->componentData = array();
    }

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->components->add(
            $component = $this->componentDomain->create(
                $this->componentType,
                $this->componentData
            )
        );

        parent::resolve();

        return $component;
    }

    /**
     * Define object component type.
     *
     * @param ComponentTypeInterface $componentType
     *
     * @return self
     */
    public function setComponentType(ComponentTypeInterface $componentType)
    {
        $this->componentType = $componentType;

        return $this;
    }

    /**
     * Define object component data.
     *
     * @param array $componentData
     *
     * @return self
     */
    public function setComponentData(array $componentData)
    {
        $this->componentData = $componentData;

        return $this;
    }
}
