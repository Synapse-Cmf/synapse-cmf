<?php

namespace Synapse\Cmf\Framework\Engine\Context\Component;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Engine\Context\Content\RenderingContextBuilder as BaseRenderingContextBuilder;
use Synapse\Cmf\Framework\Theme\Content\Resolver\ContentResolver;
use Synapse\Cmf\Framework\Engine\Resolver\VariationResolver;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;
use Synapse\Cmf\Framework\Theme\Variation\Entity\VariationContext;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Specific context builder class for component rendering purposes.
 */
class RenderingContextBuilder extends BaseRenderingContextBuilder
{
    /**
     * @var RenderingContextNormalizer
     */
    protected $contextNormalizer;

    /**
     * Construct.
     *
     * @param VariationResolver          $variationResolver
     * @param ContentResolver            $contentResolver
     * @param RenderingContextNormalizer $contextNormalizer
     */
    public function __construct(
        VariationResolver $variationResolver,
        ContentResolver $contentResolver,
        RenderingContextNormalizer $contextNormalizer
    ) {
        $this->contentResolver = $contentResolver;
        $this->variationResolver = $variationResolver;
        $this->contextNormalizer = $contextNormalizer;

        $this->options = array();
        $this->optionsResolver = new OptionsResolver();
        $this->optionsResolver->setRequired('content');
        $this->optionsResolver->setAllowedTypes('content', array(ContentInterface::class, Content::class));
        $this->optionsResolver->setRequired('theme');
        $this->optionsResolver->setAllowedTypes('theme', ThemeInterface::class);
        $this->optionsResolver->setRequired('template');
        $this->optionsResolver->setAllowedTypes('template', TemplateInterface::class);
        $this->optionsResolver->setRequired('zone');
        $this->optionsResolver->setAllowedTypes('zone', ZoneInterface::class);
        $this->optionsResolver->setRequired('component');
        $this->optionsResolver->setAllowedTypes('component', ComponentInterface::class);
    }

    /**
     * Create context from defined members.
     *
     * @return RenderingContext
     */
    public function createContext()
    {
        $resolvedOptions = $this->optionsResolver->resolve($this->options);

        // wrap content
        if ($resolvedOptions['content'] instanceof ContentInterface) {
            $resolvedOptions['content'] = $this->contentResolver->resolve(
                $resolvedOptions['content']
            );
        }

        // create variation
        $variation = $this->variationResolver->resolve((new VariationContext())
            ->denormalize($resolvedOptions)
        );

        return new RenderingContext(
            $resolvedOptions['component'],
            $resolvedOptions['content'],
            $variation,
            $this->contextNormalizer->normalize(
                $resolvedOptions['content'],
                $resolvedOptions['theme'],
                $resolvedOptions['template'],
                $resolvedOptions['zone'],
                $resolvedOptions['component']
            )
        );
    }

    /**
     * Define context builder component.
     *
     * @param ComponentInterface $component
     */
    public function setComponent(ComponentInterface $component)
    {
        $this->options['component'] = $component;

        return $this;
    }

    /**
     * Define context builder zone.
     *
     * @param ZoneInterface $zone
     */
    public function setZone(ZoneInterface $zone)
    {
        $this->options['zone'] = $zone;

        return $this;
    }

    /**
     * Define context builder template.
     *
     * @param TemplateInterface $template
     */
    public function setTemplate(TemplateInterface $template)
    {
        $this->options['template'] = $template;

        return $this;
    }
}
