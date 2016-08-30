<?php

namespace Synapse\Page\Bundle\Repository\Page;

use Majora\Framework\Repository\RepositoryInterface as MajoraRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Synapse\Page\Bundle\Entity\Page;

/**
 * Interface for Page persistence use cases.
 */
interface RepositoryInterface extends MajoraRepositoryInterface, EventSubscriberInterface
{
    /**
     * Trigger a persist call into persistence.
     *
     * @param Page $zone
     */
    public function save(Page $zone);

    /**
     * Trigger a remove call into persistence.
     *
     * @param Page $zone
     */
    public function delete(Page $zone);
}
