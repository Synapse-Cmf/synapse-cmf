<?php

namespace Synapse\Cmf\Framework\Theme\Template\Repository;

use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Majora\Framework\Repository\RepositoryInterface as MajoraRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Interface for Template persistence use cases.
 */
interface RepositoryInterface extends MajoraRepositoryInterface, EventSubscriberInterface
{
    /**
     * Trigger a persist call into persistence.
     *
     * @param Template $template
     */
    public function save(Template $template);

    /**
     * Trigger a remove call into persistence.
     *
     * @param Template $template
     */
    public function delete(Template $template);
}
