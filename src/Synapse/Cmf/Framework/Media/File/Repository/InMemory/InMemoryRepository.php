<?php

namespace Synapse\Cmf\Framework\Media\File\Repository\InMemory;

use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\File\Repository\RepositoryInterface;
use Majora\Framework\Repository\InMemory\AbstractInMemoryRepository;
use Majora\Framework\Repository\InMemory\InMemoryRepositoryTrait;

/**
 * File persistence implementation using InMemory Orm.
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
