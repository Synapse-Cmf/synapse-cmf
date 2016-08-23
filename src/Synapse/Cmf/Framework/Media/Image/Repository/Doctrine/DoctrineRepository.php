<?php

namespace Synapse\Cmf\Framework\Media\Image\Repository\Doctrine;

use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Synapse\Cmf\Framework\Media\Image\Event\Event as ImageEvent;
use Synapse\Cmf\Framework\Media\Image\Event\Events as ImageEvents;
use Synapse\Cmf\Framework\Media\Image\Repository\RepositoryInterface;
use Majora\Framework\Repository\Doctrine\BaseDoctrineRepository as MajoraDoctrineRepository;
use Majora\Framework\Repository\Doctrine\DoctrineRepositoryTrait;

/**
 * Image persistence implementation using Doctrine Orm.
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
            ImageEvents::IMAGE_CREATED => array('onWriteImage', -100),
            ImageEvents::IMAGE_EDITED => array('onWriteImage', -100),
            ImageEvents::IMAGE_DELETED => array('onDeleteImage', -100),
        );
    }

    /**
     * Image writting event handler.
     *
     * @param ImageEvent $event
     */
    public function onWriteImage(ImageEvent $event)
    {
        $this->save($event->getImage());
    }

    /**
     * Image deletion event handler.
     *
     * @param ImageEvent $event
     */
    public function onDeleteImage(ImageEvent $event)
    {
        $this->delete($event->getImage());
    }

    /**
     * Proxy for persist() repository general method.
     *
     * @see RepositoryInterface::save()
     */
    public function save(Image $image)
    {
        return $this->persist($image);
    }

    /**
     * Proxy for remove() repository general method.
     *
     * @see RepositoryInterface::delete()
     */
    public function delete(Image $image)
    {
        return $this->remove($image);
    }
}
