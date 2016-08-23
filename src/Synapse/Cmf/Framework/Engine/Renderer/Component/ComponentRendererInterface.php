<?php

namespace Synapse\Cmf\Framework\Engine\Renderer\Component;

use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Single component rendering behavior definition.
 */
interface ComponentRendererInterface
{
    /**
     * Resolve and return given component as a string.
     *
     * @param ComponentInterface $component
     * @param ZoneInterface      $zone
     *
     * @return string
     */
    public function render(ComponentInterface $component, ZoneInterface $zone);
}
