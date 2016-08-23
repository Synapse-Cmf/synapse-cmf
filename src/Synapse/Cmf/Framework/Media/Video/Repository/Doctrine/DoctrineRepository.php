<?php

namespace Synapse\Cmf\Framework\Media\Video\Repository\Doctrine;

use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Event\Event as VideoEvent;
use Synapse\Cmf\Framework\Media\Video\Event\Events as VideoEvents;
use Synapse\Cmf\Framework\Media\Video\Repository\RepositoryInterface;
use Majora\Framework\Repository\Doctrine\BaseDoctrineRepository as MajoraDoctrineRepository;
use Majora\Framework\Repository\Doctrine\DoctrineRepositoryTrait;

/**
 * Video persistence implementation using Doctrine Orm.
 */
class DoctrineRepository extends MajoraDoctrineRepository implements RepositoryInterface
{
    use DoctrineRepositoryTrait;

    /**
     * @see EventSubscriberInterface::getSubscribedEvents()
     * @codeCoverageIgnore : configuration method
     */
    public static function getSubscribedEvents()
    {
        return array(
            VideoEvents::VIDEO_CREATED => array('onWriteVideo', -100),
            VideoEvents::VIDEO_EDITED => array('onWriteVideo', -100),
            VideoEvents::VIDEO_DELETED => array('onDeleteVideo', -100),
        );
    }

    /**
     * Video writting event handler.
     *
     * @param VideoEvent $event
     */
    public function onWriteVideo(VideoEvent $event)
    {
        $this->save($event->getVideo());
    }

    /**
     * Video deletion event handler.
     *
     * @param VideoEvent $event
     */
    public function onDeleteVideo(VideoEvent $event)
    {
        $this->delete($event->getVideo());
    }

    /**
     * Proxy for persist() repository general method.
     *
     * @see RepositoryInterface::save()
     */
    public function save(Video $video)
    {
        return $this->persist($video);
    }

    /**
     * Proxy for remove() repository general method.
     *
     * @see RepositoryInterface::delete()
     */
    public function delete(Video $video)
    {
        return $this->remove($video);
    }
}
