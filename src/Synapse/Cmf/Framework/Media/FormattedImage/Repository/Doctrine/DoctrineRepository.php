<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Repository\Doctrine;

use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Event as FormattedImageEvent;
use Synapse\Cmf\Framework\Media\FormattedImage\Event\Events as FormattedImageEvents;
use Synapse\Cmf\Framework\Media\FormattedImage\Repository\RepositoryInterface;
use Majora\Framework\Repository\Doctrine\BaseDoctrineRepository as MajoraDoctrineRepository;
use Majora\Framework\Repository\Doctrine\DoctrineRepositoryTrait;

/**
 * FormattedImage persistence implementation using Doctrine Orm.
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
            FormattedImageEvents::FORMATTED_IMAGE_CREATED => array('onWriteFormattedImage', -100),
            FormattedImageEvents::FORMATTED_IMAGE_EDITED => array('onWriteFormattedImage', -100),
            FormattedImageEvents::FORMATTED_IMAGE_DELETED => array('onDeleteFormattedImage', -100),
        );
    }

    /**
     * FormattedImage writting event handler.
     *
     * @param FormattedImageEvent $event
     */
    public function onWriteFormattedImage(FormattedImageEvent $event)
    {
        $this->save($event->getFormattedImage());
    }

    /**
     * FormattedImage deletion event handler.
     *
     * @param FormattedImageEvent $event
     */
    public function onDeleteFormattedImage(FormattedImageEvent $event)
    {
        $this->delete($event->getFormattedImage());
    }

    /**
     * Proxy for persist() repository general method.
     *
     * @see RepositoryInterface::save()
     */
    public function save(FormattedImage $formattedImage)
    {
        $this->persist($formattedImage);

        // hack : check if majora doctrine proxy could listen post persist
        $this->getEntityManager()->refresh($formattedImage);

        return $formattedImage;
    }

    /**
     * Proxy for remove() repository general method.
     *
     * @see RepositoryInterface::delete()
     */
    public function delete(FormattedImage $formattedImage)
    {
        return $this->remove($formattedImage);
    }
}
