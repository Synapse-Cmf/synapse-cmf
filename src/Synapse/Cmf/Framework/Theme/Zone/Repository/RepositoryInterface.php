<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Repository;

use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Majora\Framework\Repository\RepositoryInterface as MajoraRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface for Zone persistence use cases.
 */
interface RepositoryInterface extends MajoraRepositoryInterface, EventSubscriberInterface
{
    /**
     * Trigger a persist call into persistence.
     *
     * @param Zone $zone
     */
    public function save(Zone $zone);

    /**
     * Trigger a remove call into persistence.
     *
     * @param Zone $zone
     */
    public function delete(Zone $zone);
}
