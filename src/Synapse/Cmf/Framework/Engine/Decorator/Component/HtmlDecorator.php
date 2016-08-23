<?php

namespace Synapse\Cmf\Framework\Engine\Decorator\Component;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface as TemplateEngine;
use Synapse\Cmf\Framework\Engine\Context\Component\RenderingContextBuilder;
use Synapse\Cmf\Framework\Engine\Context\RenderingContextStack;
use Synapse\Cmf\Framework\Engine\Resolver\VariationResolver;

/**
 * Component type decorator implementation using Html rendering.
 */
class HtmlDecorator extends ComponentDecorator
{
    /**
     * @var TemplateEngine
     */
    protected $templateEngine;

    /**
     * Construct.
     *
     * @param VariationResolver       $variationResolver
     * @param RenderingContextBuilder $contextBuilder
     * @param RenderingContextStack   $contextStack
     * @param TemplateEngine          $templateEngine
     */
    public function __construct(
        VariationResolver $variationResolver,
        RenderingContextBuilder $contextBuilder,
        RenderingContextStack $contextStack,
        TemplateEngine $templateEngine
    ) {
        parent::__construct($variationResolver, $contextBuilder, $contextStack);

        $this->templateEngine = $templateEngine;
    }

    /**
     * @see DecoratorInterface::render()
     */
    public function render(array $templateParameters = array())
    {
        $context = $this->contextStack->getCurrent();
        $component = $context->getComponent();

        return $this->templateEngine->render(
            $context->getTemplatePath(),
            array_replace_recursive(
                $component->normalize('template'),
                $component->getData(),
                $templateParameters
            )
        );
    }

    /**
     * @see DecoratorInterface::decorate()
     */
    public function decorate(array $templateParameters = array())
    {
        return new Response($this->render($templateParameters));
    }
}
