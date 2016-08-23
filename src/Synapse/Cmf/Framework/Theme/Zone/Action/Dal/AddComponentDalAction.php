<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Action\Dal;

use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Domain\DomainInterface as ComponentDomain;

/**
 * Zone add component action representation.
 */
class AddComponentDalAction extends UpdateAction
{
    /**
     * @var ComponentTypeInterface
     */
    protected $componentType;

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
    }

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->components->add(
            $this->componentDomain->create($this->componentType)
        );

        return parent::resolve();
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
}
