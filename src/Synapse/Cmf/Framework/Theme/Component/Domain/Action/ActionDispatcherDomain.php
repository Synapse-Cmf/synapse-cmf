<?php

namespace Synapse\Cmf\Framework\Theme\Component\Domain\Action;

use Majora\Framework\Domain\ActionDispatcherDomain as MajoraActionDispatcherDomain;
use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Domain\DomainInterface;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;

/**
 * Component domain use cases class.
 */
class ActionDispatcherDomain extends MajoraActionDispatcherDomain implements DomainInterface
{
    /**
     * @see ComponentDomainInterface::create()
     */
    public function create(ComponentTypeInterface $componentType, array $data = array())
    {
        return $this->getAction('create')
            ->setComponentType($componentType)
            ->setData($data)
            ->resolve()
        ;
    }

    /**
     * @see ComponentDomainInterface::edit()
     */
    public function edit(ComponentInterface $component, ...$arguments)
    {
        return $this->getAction('edit', $component, ...$arguments)
            ->resolve()
        ;
    }

    /**
     * @see ComponentDomainInterface::delete()
     */
    public function delete(ComponentInterface $component, ...$arguments)
    {
        return $this->getAction('delete', $component, ...$arguments)
            ->resolve()
        ;
    }
}
