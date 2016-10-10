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
     * Edit given Component with given data.
     *
     * @param ComponentInterface $component
     * @param array              $data
     */
    public function edit(ComponentInterface $component, array $data = array());

    /**
     * Delete given Component.
     *
     * @param ComponentInterface $component
     */
    public function delete(ComponentInterface $component);
}
