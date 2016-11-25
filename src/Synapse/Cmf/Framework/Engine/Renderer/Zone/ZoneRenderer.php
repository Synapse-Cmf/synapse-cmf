<?php

namespace Synapse\Cmf\Framework\Engine\Renderer\Zone;

use Synapse\Cmf\Framework\Engine\Context\RenderingContextStack;
use Synapse\Cmf\Framework\Engine\Decorator\Component\FragmentDecorator;
use Synapse\Cmf\Framework\Engine\Exception\InvalidZoneException;
use Synapse\Cmf\Framework\Theme\Component\Entity\Component;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Template\Entity\TemplateCollection;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;

/**
 * Zone renderer : trigger component rendering then aggregate it into a single string.
 */
class ZoneRenderer
{
    /**
     * @var RenderingContextStack
     */
    protected $contextStack;

    /**
     * @var ComponentDecorator
     */
    protected $componentDecorator;

    /**
     * @var array
     */
    protected $aggregators;

    /**
     * Construct.
     *
     * @param RenderingContextStack      $contextStack
     * @param ComponentRendererInterface $componentDecorator
     * @param array                      $aggregators
     */
    public function __construct(
        RenderingContextStack $contextStack,
        FragmentDecorator $componentDecorator,
        array $aggregators
    ) {
        $this->contextStack = $contextStack;
        $this->componentDecorator = $componentDecorator;
        $this->aggregators = $aggregators;
    }

    /**
     * Render given zone name on current Synapse context.
     *
     * @param string $zoneName
     * @param array  $parameters optionnal extra parameters to give to every zone components
     *
     * @return string
     */
    public function render($zoneName, array $parameters = array())
    {
        $context = $this->contextStack->getCurrent();
        $template = $context->getTemplate();

        $zoneType = $template->getTemplateType()->getZoneTypes()
            ->search(array('name' => $zoneName))
            ->first()
        ;
        if (!$zoneType) {
            throw new InvalidZoneException(sprintf(
                'Any "%s" zone defined into "%s" template. Check your configuration.',
                $zoneName,
                $template->getTemplateType()->getName()
            ));
        }

        // templates to guess components in
        $templates = new TemplateCollection(array($template));
        if (($globalTemplate = $template->getGlobalTemplate())
            && $context->isZoneVirtual($zoneName)) {             // virtual ? try to get global template components
            $templates->add($globalTemplate);
        }

        // render component into zone
        $aggregationConfig = $context->getZoneAggregation($zoneName);
        $aggregationType = $aggregationConfig['type'];

        if (!isset($this->aggregators[$aggregationType])) {
            throw new \InvalidArgumentException(sprintf(
                'Aggregation "%s" isnt registered, get one of these : ["%s"]',
                $aggregationType,
                implode('", "', array_keys($this->aggregators))
            ));
        }

        return $this->aggregators[$aggregationType]->aggregate(
            $templates->reduce(function ($carry, TemplateInterface $template) use ($zoneType, $parameters) {

                // already hydrated ?
                if (!empty($carry)) {
                    return $carry;
                }

                // look for requested zone into current template
                $zone = $template->getZones()
                    ->search(array('zoneType' => $zoneType))
                    ->first()
                ;
                if (!$zone) {  // zone is not instantiated in this template, so empty string;
                    return $carry;
                }

                return $zone->getComponents()
                    ->map(function (ComponentInterface $component) use ($zone, $parameters) {
                        return $this->componentDecorator
                            ->prepareFromCurrentContext($zone, $component)
                            ->render($parameters)
                        ;
                    })
                    ->toArray()
                ;
            }, []),
            $aggregationConfig
        );
    }
}
