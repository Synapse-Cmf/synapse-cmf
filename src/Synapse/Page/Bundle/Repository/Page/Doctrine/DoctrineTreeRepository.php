<?php

namespace Synapse\Page\Bundle\Repository\Page\Doctrine;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Majora\Framework\Repository\Doctrine\DoctrineRepositoryTrait;
use Synapse\Page\Bundle\Entity\Page;
use Synapse\Page\Bundle\Event\Page\Event as PageEvent;
use Synapse\Page\Bundle\Event\Page\Events as PageEvents;
use Synapse\Page\Bundle\Repository\Page\RepositoryInterface;

/**
 * Page repository implementation using Doctrine and NestedSet behavior.
 */
class DoctrineTreeRepository extends NestedTreeRepository implements RepositoryInterface
{
    use DoctrineRepositoryTrait;

    /**
     * @see EventSubscriberInterface::getSubscribedEvents()
     * @codeCoverageIgnore : configuration method
     */
    public static function getSubscribedEvents()
    {
        return array(
            PageEvents::PAGE_CREATED => array('onWritePage', -100),
            PageEvents::PAGE_EDITED => array('onWritePage', -100),
            PageEvents::PAGE_DELETED => array('onDeletePage', -100),
        );
    }

    /**
     * Page writting event handler.
     *
     * @param PageEvent $event
     */
    public function onWritePage(PageEvent $event)
    {
        $this->save($event->getPage());
    }

    /**
     * Page deletion event handler.
     *
     * @param PageEvent $event
     */
    public function onDeletePage(PageEvent $event)
    {
        $this->delete($event->getPage());
    }

    /**
     * Proxy for persist() repository general method.
     *
     * @see RepositoryInterface::save()
     */
    public function save(Page $page)
    {
        return $this->persist($page);
    }

    /**
     * Proxy for remove() repository general method.
     *
     * @see RepositoryInterface::delete()
     */
    public function delete(Page $page)
    {
        return $this->remove($page);
    }
}
