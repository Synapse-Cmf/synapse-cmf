<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Action\Dal;

use Synapse\Cmf\Framework\Theme\Zone\Action\AbstractAction;
use Majora\Framework\Domain\Action\Dal\DalActionTrait;

/**
 * Base class for Zone Dal centric actions.
 *
 * @property $zone
 */
abstract class AbstractDalAction extends AbstractAction
{
    use DalActionTrait;
}
