<?php

namespace Synapse\Page\Bundle\Domain\Page\Action;

use Majora\Framework\Domain\ActionDispatcherDomain as MajoraActionDispatcherDomain;
use Synapse\Page\Bundle\Domain\Page\DomainInterface;
use Synapse\Page\Bundle\Entity\Page;

/**
 * Page domain use cases class using actions.
 */
class ActionDispatcherDomain extends MajoraActionDispatcherDomain implements DomainInterface
{
    /**
     * @see DomainInterface::create()
     */
    public function create(
        $name,
        Page $parent = null,
        $path = '',
        $online = false,
        $title = null,
        array $meta = array(),
        array $openGraph = array()
    ) {
        return $this
            ->getAction('create')
                ->setName($name)
                ->setParent($parent)
                ->setPath($path)
                ->setOnline($online)
                ->setTitle($title)
                ->setMeta($meta)
                ->setOpenGraph($openGraph)
            ->resolve()
        ;
    }

    /**
     * @see DomainInterface::edit()
     */
    public function edit(
        Page $page,
        $name,
        $online = false,
        $title = null,
        array $meta = array(),
        array $openGraph = array())
    {
        return $this
            ->getAction('edit', $page)
                ->setName($name)
                ->setOnline($online)
                ->setTitle($title)
                ->setMeta($meta)
                ->setOpenGraph($openGraph)
            ->resolve()
        ;
    }

    /**
     * @see DomainInterface::delete()
     */
    public function delete(Page $page, ...$arguments)
    {
        return $this->getAction('delete', $page, ...$arguments)
            ->resolve()
        ;
    }
}
