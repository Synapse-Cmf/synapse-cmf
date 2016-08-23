<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Repository\InMemory;

use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Repository\RepositoryInterface;
use Majora\Framework\Repository\InMemory\AbstractInMemoryRepository;
use Majora\Framework\Repository\InMemory\InMemoryRepositoryTrait;

/**
 * FormattedImage persistence implementation using InMemory Orm.
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
    public function save(FormattedImage $formattedImage)
    {
        return $this->persist($formattedImage);
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
