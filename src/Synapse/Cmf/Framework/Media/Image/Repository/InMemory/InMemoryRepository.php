<?php

namespace Synapse\Cmf\Framework\Media\Image\Repository\InMemory;

use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Synapse\Cmf\Framework\Media\Image\Repository\RepositoryInterface;
use Majora\Framework\Repository\InMemory\AbstractInMemoryRepository;
use Majora\Framework\Repository\InMemory\InMemoryRepositoryTrait;

/**
 * Image persistence implementation using InMemory Orm.
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
