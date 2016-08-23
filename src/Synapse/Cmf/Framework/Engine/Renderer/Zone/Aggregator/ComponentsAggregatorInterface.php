<?php

namespace Synapse\Cmf\Framework\Engine\Renderer\Zone\Aggregator;

/**
 * Component aggregation strategy interface,
 * define how components will be displayed in a zone.
 */
interface ComponentsAggregatorInterface
{
    /**
     * Aggregate and return given rendered component collection as a single string.
     *
     * @param array $renderedComponents
     * @param array $options
     *
     * @return string
     */
    public function aggregate(array $renderedComponents, array $options = array());
}
