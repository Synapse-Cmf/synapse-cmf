<?php

namespace Synapse\Cmf\Framework\Engine\Renderer\Zone\Aggregator;

/**
 * Component aggregator which aggregate all components on the same line.
 */
class InlineAggregator implements ComponentsAggregatorInterface
{
    /**
     * @see ComponentsAggregatorInterface::aggregate()
     */
    public function aggregate(array $renderedComponents, array $options = array())
    {
        return implode('', $renderedComponents);
    }
}
