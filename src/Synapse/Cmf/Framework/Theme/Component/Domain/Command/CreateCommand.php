<?php

namespace Synapse\Cmf\Framework\Theme\Component\Domain\Command;

use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Event\Event as ComponentEvent;
use Synapse\Cmf\Framework\Theme\Component\Event\Events as ComponentEvents;

/**
 * Component creation action representation.
 */
class CreateCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $componentClass;

    /**
     * @var ComponentTypeInterface
     */
    protected $componentType;

    /**
     * @var array
     */
    protected $data;

    /**
     * Construct.
     *
     * @param string $componentClass
     */
    public function __construct($componentClass = Component::class)
    {
        $this->componentClass = $componentClass;
        $this->data = array();
    }

    /**
     * Component creation method.
     *
     * @return Component
     */
    public function resolve()
    {
        if (empty($this->componentType)) {
            throw new \BadMethodCallException('You have to provide a component type to create a component.');
        }

        $this->component = new $this->componentClass();
        $this->component->setComponentType($this->componentType);
        $this->component->setData($this->data);

        $this->assertEntityIsValid($this->component, array('Component', 'creation'));

        $this->fireEvent(
            ComponentEvents::COMPONENT_CREATED,
            new ComponentEvent($this->component, $this)
        );

        return $this->component;
    }

    /**
     * Returns action component type.
     *
     * @return ComponentTypeInterface
     */
    public function getComponentType()
    {
        return $this->componentType;
    }

    /**
     * Define action component type.
     *
     * @param ComponentTypeInterface $componentType
     *
     * @return self
     */
    public function setComponentType(ComponentTypeInterface $componentType = null)
    {
        $this->componentType = $componentType;

        return $this;
    }

    /**
     * Returns action component data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Define action component data.
     *
     * @param array $data
     *
     * @return self
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }
}
