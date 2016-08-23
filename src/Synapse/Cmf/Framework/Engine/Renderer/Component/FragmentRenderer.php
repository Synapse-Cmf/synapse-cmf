<?php

namespace Synapse\Cmf\Framework\Engine\Renderer\Component;

use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;
use Synapse\Cmf\Framework\Engine\Context\RenderingContextStack;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Component renderer implementation using Symfony Fragment handler to be able to generate esi tags, hincludes...
 */
class FragmentRenderer implements ComponentRendererInterface
{
    /**
     * @var RenderingContextStack
     */
    protected $contextStack;

    /**
     * @var FragmentHandler
     */
    protected $fragmentHandler;

    /**
     * @var string
     */
    protected $subrequestZoneParameter;

    /**
     * @var string
     */
    protected $subrequestComponentParameter;

    /**
     * Construct.
     *
     * @param RenderingContextStack $contextStack
     * @param FragmentHandler       $fragmentHandler
     * @param string                $subrequestZoneParameter
     * @param string                $subrequestComponentParameter
     */
    public function __construct(
        RenderingContextStack $contextStack,
        FragmentHandler $fragmentHandler,
        $subrequestZoneParameter,
        $subrequestComponentParameter
    ) {
        $this->contextStack = $contextStack;
        $this->fragmentHandler = $fragmentHandler;
        $this->subrequestZoneParameter = $subrequestZoneParameter;
        $this->subrequestComponentParameter = $subrequestComponentParameter;
    }

    /**
     * @see ComponentRendererInterface::render()
     */
    public function render(ComponentInterface $component, ZoneInterface $zone)
    {
        return $this->fragmentHandler->render(new ControllerReference(
            $this->context->getComponentController($zone, $component),
            array(),
            array(
                $this->subrequestZoneParameter => $zone->getId(),
                $this->subrequestComponentParameter => $component->getId(),
            )
        ));
    }
}
