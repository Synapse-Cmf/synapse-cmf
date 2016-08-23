<?php

namespace Synapse\Cmf\Framework\Engine\Context\Content;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Theme\Content\Resolver\ContentResolver;
use Synapse\Cmf\Framework\Engine\Resolver\TemplateResolver;
use Synapse\Cmf\Framework\Engine\Resolver\VariationResolver;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;
use Synapse\Cmf\Framework\Theme\Variation\Entity\VariationContext;

/**
 * Builder class for synapse rendering context.
 */
class RenderingContextBuilder
{
    /**
     * @var TemplateResolver
     */
    protected $templateResolver;

    /**
     * @var ContentResolver
     */
    protected $contentResolver;

    /**
     * @var VariationResolver
     */
    protected $variationResolver;

    /**
     * @var OptionsResolver
     */
    protected $optionsResolver;

    /**
     * @var array
     */
    protected $options;

    /**
     * Construct.
     *
     * @param TemplateResolver  $templateResolver
     * @param ContentResolver   $contentResolver
     * @param VariationResolver $variationResolver
     */
    public function __construct(
        TemplateResolver $templateResolver,
        ContentResolver $contentResolver,
        VariationResolver $variationResolver
    ) {
        $this->templateResolver = $templateResolver;
        $this->contentResolver = $contentResolver;
        $this->variationResolver = $variationResolver;
        $this->options = array();
        $this->optionsResolver = new OptionsResolver();

        $this->optionsResolver->setDefault('templateTypeName', null);
        $this->optionsResolver->setAllowedTypes('templateTypeName', array('string', 'null'));
        $this->optionsResolver->setRequired('content');
        $this->optionsResolver->setAllowedTypes('content', ContentInterface::class);
        $this->optionsResolver->setRequired('theme');
        $this->optionsResolver->setAllowedTypes('theme', ThemeInterface::class);
    }

    /**
     * Create context from defined members.
     *
     * @return RenderingContext
     */
    public function createContext()
    {
        // context options
        $resolvedOptions = $this->optionsResolver->resolve($this->options);
        $resolvedOptions['content'] = $this->contentResolver->resolve(
            $resolvedOptions['content']
        );

        // create variation
        $variation = $this->variationResolver->resolve(
            (new VariationContext())->denormalize($resolvedOptions)
        );

        return new RenderingContext(
            $resolvedOptions['content'],
            $resolvedOptions['theme'],
            $this->templateResolver->resolve(
                $resolvedOptions['theme'],
                $resolvedOptions['content'],
                $variation,
                $resolvedOptions['templateTypeName']
            ),
            $variation
        );
    }

    /**
     * Define context builder content.
     *
     * @param ContentInterface|Content $content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->options['content'] = $content;

        return $this;
    }

    /**
     * Define context builder theme.
     *
     * @param ThemeInterface $theme
     *
     * @return self
     */
    public function setTheme(ThemeInterface $theme)
    {
        $this->options['theme'] = $theme;

        return $this;
    }

    /**
     * Define context builder template type name.
     *
     * @param string $templateTypeName
     *
     * @return self
     */
    public function setTemplateTypeName($templateTypeName)
    {
        $this->options['templateTypeName'] = $templateTypeName;

        return $this;
    }
}
