<?php

namespace Synapse\Cmf\Framework\Media\Video\Action\Dal;

use Synapse\Cmf\Framework\Media\Video\Action\AbstractAction;
use Majora\Framework\Domain\Action\Dal\DalActionTrait;

/**
 * Base class for Video Dal centric actions.
 *
 * @property $video
 */
abstract class AbstractDalAction extends AbstractAction
{
    use DalActionTrait;
}
