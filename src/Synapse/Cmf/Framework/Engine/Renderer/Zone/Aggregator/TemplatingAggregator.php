<?php

namespace Synapse\Cmf\Framework\Engine\Renderer\Zone\Aggregator;

use Symfony\Component\Templating\EngineInterface as TemplateEngine;

/**
 * Component aggregator which aggregate all components with a twig template.
 */
class TemplatingAggregator implements ComponentsAggregatorInterface
{
    /**
     * @var TemplateEngine
     */
    protected $templateEngine;

    /**
     * Construct.
     *
     * @param TemplateEngine $templateEngine
     */
    public function __construct(TemplateEngine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    /**
     * @see ComponentsAggregatorInterface::aggregate()
     */
    public function aggregate(array $renderedComponents, array $options = array())
    {
        if (empty($options['path'])) {
            throw new \InvalidArgumentException('You have to provide rendering template throught "path" option, "%s" given.');
        }

        return $this->templateEngine->render($options['path'], array_replace_recursive(
            $options,
            array('components' => $renderedComponents)
        ));
    }
}
