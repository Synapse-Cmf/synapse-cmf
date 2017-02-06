<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Domain\Command;

use Synapse\Cmf\Framework\Theme\Component\Domain\DomainInterface as ComponentDomain;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;

/**
 * Zone component removal command representation.
 */
class RemoveComponentCommand extends UpdateCommand
{
    /**
     * @var ComponentDomain
     */
    protected $componentDomain;

    /**
     * @var ComponentInterface
     */
    protected $component;

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
        $this->components->remove(
            $this->component->getId()
        );

        $this->componentDomain->delete($component);

        return parent::resolve();
    }

    /**
     * Define component to delete.
     *
     * @param ComponentInterface $component
     *
     * @return self
     */
    public function setComponent(ComponentInterface $component)
    {
        $this->component = $component;

        return $this;
    }
}
