<?php

namespace Synapse\Cmf\Framework\Theme\Component\Action\Dal;

use Synapse\Cmf\Framework\Theme\Component\Action\AbstractAction;
use Majora\Framework\Domain\Action\Dal\DalActionTrait;

/**
 * Base class for Component Dal centric actions.
 *
 * @property $component
 */
abstract class AbstractDalAction extends AbstractAction
{
    use DalActionTrait;
}
