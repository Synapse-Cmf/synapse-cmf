<?php

namespace Synapse\Cmf\Framework\Media\Video\Action;

use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Model\VideoInterface;
use Majora\Framework\Domain\Action\AbstractAction as MajoraAbstractAction;

/**
 * Base class for Video Actions.
 *
 * @property $video
 */
abstract class AbstractAction extends MajoraAbstractAction
{
    /**
     * @var VideoInterface
     */
    protected $video;

    /**
     * Initialisation function.
     *
     * @param VideoInterface $video
     */
    public function init(VideoInterface $video = null)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Return related Video if defined.
     *
     * @return VideoInterface|null $video
     */
    public function getVideo()
    {
        return $this->video;
    }
}
