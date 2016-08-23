<?php

namespace Synapse\Cmf\Framework\Theme\Component\Repository\Doctrine;

use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Event\Event as ComponentEvent;
use Synapse\Cmf\Framework\Theme\Component\Event\Events as ComponentEvents;
use Synapse\Cmf\Framework\Theme\Component\Repository\RepositoryInterface;
use Majora\Framework\Repository\Doctrine\BaseDoctrineRepository as MajoraDoctrineRepository;
use Majora\Framework\Repository\Doctrine\DoctrineRepositoryTrait;

/**
 * Component persistence implementation using Doctrine Orm.
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
            ComponentEvents::COMPONENT_CREATED => array('onWriteComponent', -100),
            ComponentEvents::COMPONENT_EDITED => array('onWriteComponent', -100),
            ComponentEvents::COMPONENT_DELETED => array('onDeleteComponent', -100),
        );
    }

    /**
     * Component writting event handler.
     *
     * @param ComponentEvent $event
     */
    public function onWriteComponent(ComponentEvent $event)
    {
        $this->save($event->getComponent());
    }

    /**
     * Component deletion event handler.
     *
     * @param ComponentEvent $event
     */
    public function onDeleteComponent(ComponentEvent $event)
    {
        $this->delete($event->getComponent());
    }

    /**
     * Proxy for persist() repository general method.
     *
     * @see RepositoryInterface::save()
     */
    public function save(Component $component)
    {
        return $this->persist($component);
    }

    /**
     * Proxy for remove() repository general method.
     *
     * @see RepositoryInterface::delete()
     */
    public function delete(Component $component)
    {
        return $this->remove($component);
    }
}
