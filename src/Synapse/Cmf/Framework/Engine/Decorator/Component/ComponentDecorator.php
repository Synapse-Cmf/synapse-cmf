<?php

namespace Synapse\Cmf\Framework\Engine\Decorator\Component;

use Synapse\Cmf\Framework\Engine\Context\Component\RenderingContextBuilder;
use Synapse\Cmf\Framework\Engine\Context\RenderingContextStack;
use Synapse\Cmf\Framework\Engine\Decorator\DecoratorInterface;
use Synapse\Cmf\Framework\Engine\Resolver\VariationResolver;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Base class for component decorator.
 */
abstract class ComponentDecorator implements DecoratorInterface
{
    /**
     * @var VariationResolver
     */
    protected $variationResolver;

    /**
     * @var RenderingContextBuilder
     */
    protected $contextBuilder;

    /**
     * @var RenderingContextStack
     */
    protected $contextStack;

    /**
     * Construct.
     *
     * @param VariationResolver       $variationResolver
     * @param RenderingContextBuilder $contextBuilder
     * @param RenderingContextStack   $contextStack
     */
    public function __construct(
        VariationResolver $variationResolver,
        RenderingContextBuilder $contextBuilder,
        RenderingContextStack $contextStack
    ) {
        $this->variationResolver = $variationResolver;
        $this->contextBuilder = $contextBuilder;
        $this->contextStack = $contextStack;
    }

    /**
     * Prepare decorator context.
     *
     * @param ContentInterface|Content $content
     * @param ThemeInterface           $theme
     * @param TemplateInterface        $template
     * @param ZoneInterface            $zone
     * @param ComponentInterface       $component
     *
     * @return self
     */
    public function prepare(
        $content,
        ThemeInterface $theme,
        TemplateInterface $template,
        ZoneInterface $zone,
        ComponentInterface $component
    ) {
        $this->contextStack->push(
            $this->contextBuilder
                ->setContent($content)
                ->setTheme($theme)
                ->setTemplate($template)
                ->setZone($zone)
                ->setComponent($component)
            ->createContext()
        );

        return $this;
    }
}
