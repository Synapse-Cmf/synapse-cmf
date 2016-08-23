<?php

namespace Synapse\Cmf\Framework\Media\File\Repository\Doctrine;

use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\File\Event\Event as FileEvent;
use Synapse\Cmf\Framework\Media\File\Event\Events as FileEvents;
use Synapse\Cmf\Framework\Media\File\Repository\RepositoryInterface;
use Majora\Framework\Repository\Doctrine\BaseDoctrineRepository as MajoraDoctrineRepository;
use Majora\Framework\Repository\Doctrine\DoctrineRepositoryTrait;

/**
 * File persistence implementation using Doctrine Orm.
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
            FileEvents::FILE_CREATED => array('onWriteFile', -100),
            FileEvents::FILE_EDITED => array('onWriteFile', -100),
            FileEvents::FILE_DELETED => array('onDeleteFile', -100),
        );
    }

    /**
     * File writting event handler.
     *
     * @param FileEvent $event
     */
    public function onWriteFile(FileEvent $event)
    {
        $this->save($event->getFile());
    }

    /**
     * File deletion event handler.
     *
     * @param FileEvent $event
     */
    public function onDeleteFile(FileEvent $event)
    {
        $this->delete($event->getFile());
    }

    /**
     * Proxy for persist() repository general method.
     *
     * @see RepositoryInterface::save()
     */
    public function save(File $file)
    {
        return $this->persist($file);
    }

    /**
     * Proxy for remove() repository general method.
     *
     * @see RepositoryInterface::delete()
     */
    public function delete(File $file)
    {
        return $this->remove($file);
    }
}
