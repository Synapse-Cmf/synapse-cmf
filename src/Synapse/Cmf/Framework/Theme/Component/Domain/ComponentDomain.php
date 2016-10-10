<?php

namespace Synapse\Cmf\Framework\Theme\Component\Domain;

use Majora\Framework\Domain\Action\ActionFactory;
use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;

/**
 * Component domain use cases class.
 */
class ComponentDomain implements DomainInterface
{
    /**
     * @var ActionFactory
     */
    protected $commandFactory;

    /**
     * Construct.
     *
     * @param ActionFactory $commandFactory
     */
    public function __construct(ActionFactory $commandFactory)
    {
        $this->commandFactory = $commandFactory;
    }

    /**
     * @see ComponentDomainInterface::create()
     */
    public function create(ComponentTypeInterface $componentType, array $data = array())
    {
        return $this->commandFactory
            ->createAction('create')
                ->setComponentType($componentType)
                ->setData($data)
            ->resolve()
        ;
    }

    /**
     * @see ComponentDomainInterface::edit()
     */
    public function edit(ComponentInterface $component, array $data = array())
    {
        return $this->commandFactory
            ->createAction('edit')
                ->init($component)
                ->setData($data)
            ->resolve()
        ;
    }

    /**
     * @see ComponentDomainInterface::delete()
     */
    public function delete(ComponentInterface $component, ...$arguments)
    {
        return $this->commandFactory
            ->createAction('delete')
                ->init($component)
            ->resolve()
        ;
    }
}
