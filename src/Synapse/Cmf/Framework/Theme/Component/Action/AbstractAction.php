<?php

namespace Synapse\Cmf\Framework\Theme\Component\Action;

use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Majora\Framework\Domain\Action\AbstractAction as MajoraAbstractAction;

/**
 * Base class for Component Actions.
 *
 * @property $component
 */
abstract class AbstractAction extends MajoraAbstractAction
{
    /**
     * @var ComponentInterface
     */
    protected $component;

    /**
     * Initialisation function.
     *
     * @param ComponentInterface $component
     */
    public function init(ComponentInterface $component = null)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Return related Component if defined.
     *
     * @return ComponentInterface|null $component
     */
    public function getComponent()
    {
        return $this->component;
    }
}
