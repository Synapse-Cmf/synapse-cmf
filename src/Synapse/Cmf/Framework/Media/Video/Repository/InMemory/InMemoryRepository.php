<?php

namespace Synapse\Cmf\Framework\Media\Video\Repository\InMemory;

use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Repository\RepositoryInterface;
use Majora\Framework\Repository\InMemory\AbstractInMemoryRepository;
use Majora\Framework\Repository\InMemory\InMemoryRepositoryTrait;

/**
 * Video persistence implementation using InMemory Orm.
 */
class InMemoryRepository extends AbstractInMemoryRepository implements RepositoryInterface
{
    use InMemoryRepositoryTrait;

    /**
     * @see EventSubscriberInterface::getSubscribedEvents()
     * @codeCoverageIgnore : configuration method
     */
    public static function getSubscribedEvents()
    {
        return array();
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
