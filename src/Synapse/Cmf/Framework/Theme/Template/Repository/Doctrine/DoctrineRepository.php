<?php

namespace Synapse\Cmf\Framework\Theme\Template\Repository\Doctrine;

use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Event\Event as TemplateEvent;
use Synapse\Cmf\Framework\Theme\Template\Event\Events as TemplateEvents;
use Synapse\Cmf\Framework\Theme\Template\Repository\RepositoryInterface;
use Majora\Framework\Repository\Doctrine\BaseDoctrineRepository as MajoraDoctrineRepository;
use Majora\Framework\Repository\Doctrine\DoctrineRepositoryTrait;

/**
 * Template persistence implementation using Doctrine Orm.
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
            TemplateEvents::TEMPLATE_CREATED => array('onWriteTemplate', -100),
            TemplateEvents::TEMPLATE_EDITED => array('onWriteTemplate', -100),
            TemplateEvents::TEMPLATE_DELETED => array('onDeleteTemplate', -100),
        );
    }

    /**
     * Template writting event handler.
     *
     * @param TemplateEvent $event
     */
    public function onWriteTemplate(TemplateEvent $event)
    {
        $this->save($event->getTemplate());
    }

    /**
     * Template deletion event handler.
     *
     * @param TemplateEvent $event
     */
    public function onDeleteTemplate(TemplateEvent $event)
    {
        $this->delete($event->getTemplate());
    }

    /**
     * Proxy for persist() repository general method.
     *
     * @see RepositoryInterface::save()
     */
    public function save(Template $template)
    {
        return $this->persist($template);
    }

    /**
     * Proxy for remove() repository general method.
     *
     * @see RepositoryInterface::delete()
     */
    public function delete(Template $template)
    {
        return $this->remove($template);
    }
}
