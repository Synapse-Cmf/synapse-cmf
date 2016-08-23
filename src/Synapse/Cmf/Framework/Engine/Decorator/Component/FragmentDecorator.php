<?php

namespace Synapse\Cmf\Framework\Engine\Decorator\Component;

use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;
use Synapse\Cmf\Framework\Engine\Context\Component\RenderingContextBuilder;
use Synapse\Cmf\Framework\Engine\Context\Content\RenderingContext as TemplateRenderingContext;
use Synapse\Cmf\Framework\Engine\Context\RenderingContextStack;
use Synapse\Cmf\Framework\Engine\Resolver\VariationResolver;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Component decorator class using Symfony fragment renderer.
 */
class FragmentDecorator extends ComponentDecorator
{
    /**
     * @var FragmentHandler
     */
    protected $fragmentHandler;

    /**
     * Construct.
     *
     * @param VariationResolver       $variationResolver
     * @param RenderingContextBuilder $contextBuilder
     * @param RenderingContextStack   $contextStack
     * @param FragmentHandler         $fragmentHandler
     */
    public function __construct(
        VariationResolver $variationResolver,
        RenderingContextBuilder $contextBuilder,
        RenderingContextStack $contextStack,
        FragmentHandler $fragmentHandler
    ) {
        parent::__construct($variationResolver, $contextBuilder, $contextStack);

        $this->fragmentHandler = $fragmentHandler;
    }

    /**
     * Proxy to prepare() method, using current context as argument.
     *
     * @param ComponentInterface $component
     * @param RenderingContext   $templateContext
     *
     * @return self
     */
    public function prepareFromCurrentContext(
        ZoneInterface $zone,
        ComponentInterface $component
    ) {
        $templateContext = $this->contextStack->getCurrent();
        if (!$templateContext instanceof TemplateRenderingContext) {
            throw new \BadMethodCallException(sprintf(
                '%s() cannot be used without an active template rendering context.',
                __METHOD__
            ));
        }

        return $this->prepare(
            $templateContext->getContent(),
            $templateContext->getTheme(),
            $templateContext->getTemplate(),
            $zone,
            $component
        );
    }

    /**
     * @see ComponentDecorator::render()
     */
    public function render(array $templateParameters = array())
    {
        $context = $this->contextStack->getCurrent();

        $fragment = $this->fragmentHandler->render(new ControllerReference(
            $context->getController(),
            array(),
            $context->normalize()
        ));

        $this->contextStack->pop();

        return $fragment;
    }

    /**
     * @see ComponentDecorator::decorate()
     */
    public function decorate(array $templateParameters = array())
    {
        throw new \BadMethodCallException('Cannot render fragments as responses.');
    }
}
