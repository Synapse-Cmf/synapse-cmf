<?php

namespace Synapse\Cmf\Framework\Theme\Component\Action\Dal;

use Synapse\Cmf\Framework\Theme\Component\Event\Event as ComponentEvent;
use Synapse\Cmf\Framework\Theme\Component\Event\Events as ComponentEvents;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;

/**
 * Component edition action representation.
 */
class UpdateAction extends AbstractDalAction
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Initialisation function.
     *
     * @param ComponentInterface $zone
     */
    public function init(ComponentInterface $component = null)
    {
        if (!$component) {
            return $this;
        }

        $this->component = $component;
        $this->data = $component->getData();

        return $this;
    }

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        $this->component->setData($this->data);

        $this->assertEntityIsValid($this->component, array('Component', 'edition'));

        $this->fireEvent(
            ComponentEvents::COMPONENT_EDITED,
            new ComponentEvent($this->component, $this)
        );
    }

    /**
     * Returns action data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Define action data.
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
