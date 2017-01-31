<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Repository\Doctrine;

use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Event\Event as ZoneEvent;
use Synapse\Cmf\Framework\Theme\Zone\Event\Events as ZoneEvents;
use Synapse\Cmf\Framework\Theme\Zone\Repository\RepositoryInterface;
use Majora\Framework\Repository\Doctrine\BaseDoctrineRepository as MajoraDoctrineRepository;
use Majora\Framework\Repository\Doctrine\DoctrineRepositoryTrait;

/**
 * Zone persistence implementation using Doctrine Orm.
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
            ZoneEvents::ZONE_CREATED => array('onCreateZone', -100),
            ZoneEvents::ZONE_EDITED => array('onWriteZone', -100),
            ZoneEvents::ZONE_DELETED => array('onDeleteZone', -100),
        );
    }

    /**
     * Zone creation event handler.
     * Triggers persistence call only if component was defined into it.
     *
     * @param ZoneEvent $event
     */
    public function onCreateZone(ZoneEvent $event)
    {
        $zone = $event->getZone();
        if ($zone->getComponents()->isEmpty()) {
            return;
        }

        $this->save($zone);
    }

    /**
     * Zone writting event handler.
     *
     * @param ZoneEvent $event
     */
    public function onWriteZone(ZoneEvent $event)
    {
        $this->save($event->getZone());
    }

    /**
     * Zone deletion event handler.
     *
     * @param ZoneEvent $event
     */
    public function onDeleteZone(ZoneEvent $event)
    {
        $this->delete($event->getZone());
    }

    /**
     * Proxy for persist() repository general method.
     *
     * @see RepositoryInterface::save()
     */
    public function save(Zone $zone)
    {
        return $this->persist($zone);
    }

    /**
     * Proxy for remove() repository general method.
     *
     * @see RepositoryInterface::delete()
     */
    public function delete(Zone $zone)
    {
        return $this->remove($zone);
    }
}
