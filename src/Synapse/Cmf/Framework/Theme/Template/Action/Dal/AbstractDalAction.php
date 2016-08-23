<?php

namespace Synapse\Cmf\Framework\Theme\Template\Action\Dal;

use Synapse\Cmf\Framework\Theme\Template\Action\AbstractAction;
use Majora\Framework\Domain\Action\Dal\DalActionTrait;

/**
 * Base class for Template Dal centric actions.
 *
 * @property $template
 */
abstract class AbstractDalAction extends AbstractAction
{
    use DalActionTrait;
}
