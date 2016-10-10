<?php

namespace Synapse\Cmf\Framework\Theme\Component\Domain\Command;

use Majora\Framework\Domain\Action\ActionInterface;
use Majora\Framework\Domain\Action\Dal\DalActionTrait;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;

/**
 * Base class for Component Commands.
 *
 * @property $component
 */
abstract class AbstractCommand implements ActionInterface
{
    use DalActionTrait;

    /**
     * @var ComponentInterface
     */
    protected $component;

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
