<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Action\Dal;

use Synapse\Cmf\Framework\Media\FormattedImage\Action\AbstractAction;
use Majora\Framework\Domain\Action\Dal\DalActionTrait;

/**
 * Base class for FormattedImage Dal centric actions.
 *
 * @property $formattedImage
 */
abstract class AbstractDalAction extends AbstractAction
{
    use DalActionTrait;
}
