<?php

namespace Synapse\Cmf\Framework\Theme\Component\Domain;

use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;

/**
 * Interface for Component domain use cases.
 */
interface DomainInterface
{
    /**
     * Create and returns a new Component from given type and data.
     *
     * @param ComponentTypeInterface $componentType
     * @param array                  $data
     *
     * @return ComponentInterface
     */
    public function create(ComponentTypeInterface $componentType, array $data = array());

    /**
     * Create and returns an action for update a Component.
     *
     * @param ComponentInterface $component
     *
     * @return UpdateComponentAction
     */
    public function edit(ComponentInterface $component);

    /**
     * Create and returns an action for delete a Component.
     *
     * @param ComponentInterface $component
     *
     * @return DeleteComponentAction
     */
    public function delete(ComponentInterface $component);
}
