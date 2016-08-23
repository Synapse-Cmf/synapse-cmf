<?php

namespace Synapse\Cmf\Framework\Theme\Component\Repository;

use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Majora\Framework\Repository\RepositoryInterface as MajoraRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface for Component persistence use cases.
 */
interface RepositoryInterface extends MajoraRepositoryInterface, EventSubscriberInterface
{
    /**
     * Trigger a persist call into persistence.
     *
     * @param Component $component
     */
    public function save(Component $component);

    /**
     * Trigger a remove call into persistence.
     *
     * @param Component $component
     */
    public function delete(Component $component);
}
