<?php

namespace Synapse\Cmf\Framework\Engine\Resolver;

use Majora\Framework\Model\EntityCollection;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;
use Synapse\Cmf\Framework\Theme\Variation\Entity\Variation;
use Synapse\Cmf\Framework\Theme\Variation\Entity\VariationContext;

/**
 * Variation resolver class, select config create variation objects from current context.
 */
class VariationResolver implements VariationProviderInterface
{
    /**
     * @var array
     */
    protected $variationConfigs;

    /**
     * @var PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * @var ExpressionLanguage
     */
    protected $expressionParser;

    /**
     * @var EntityCollection
     */
    protected $variationProviderCollection;

    /**
     * Construct.
     *
     * @param PropertyAccessor   $propertyAccessor
     * @param ExpressionLanguage $expressionParser
     */
    public function __construct(
        PropertyAccessor $propertyAccessor,
        ExpressionLanguage $expressionParser
    ) {
        $this->propertyAccessor = $propertyAccessor;
        $this->expressionParser = $expressionParser;

        $this->variationConfigs = new EntityCollection();

        $this->variationProviderCollection = new EntityCollection();
        $this->registerVariationProvider($this);
    }

    /**
     * Register a new variation config under given namespace.
     *
     * @param string $namespace
     * @param array  $variationConfig
     */
    public function registerVariationConfig($namespace, array $variationConfig)
    {
        $this->variationConfigs->set($namespace, $variationConfig);
    }

    /**
     * Register a variation provider class.
     *
     * @param VariationProviderInterface $variationProvider
     */
    public function registerVariationProvider(VariationProviderInterface $variationProvider)
    {
        $this->variationProviderCollection->add($variationProvider);
    }

    /**
     * @see VariationProviderInterface::hydrateContext
     */
    public function hydrateContext(VariationContext $context)
    {
        $variationContext = new VariationContext();
        $variationContext->denormalize(array(
            'theme' => $context->theme->getName(),
            'content' => '',
            'template' => '',
            'zone' => '',
        ));

        // content
        if (!empty($context->content)) {
            $context->content_type = $context->content->getType();
        }
        if (!empty($context->content_type)) {
            $variationContext->content = $context->content_type->getName();
        }

        // template
        if (!empty($context->templateTypeName)) {
            $variationContext->template = $context->templateTypeName;
        }
        if (!empty($context->template)) {
            $context->template_type = $context->template->getTemplateType();
        }
        if (!empty($context->template_type)) {
            $variationContext->template = $context->template_type->getName();
        }

        // zone
        if (!empty($context->zone)) {
            $context->zone_type = $context->zone->getZoneType();
        }
        if (!empty($context->zone_type)) {
            $variationContext->zone = $context->zone_type->getName();
        }

        return $variationContext;
    }

    /**
     * Create and resolve a variation from given context.
     *
     * @param Content        $content
     * @param ThemeInterface $theme
     *
     * @return Variation
     */
    public function resolve(VariationContext $variationContext)
    {
        // run variation providers
        $variationContext = $this->variationProviderCollection->reduce(
            function (VariationContext $context, VariationProviderInterface $variationProvider) {
                return $variationProvider->hydrateContext($context) ?: $context;
            },
            $variationContext
        );

        // requires theme as context option : theme is variation namespace
        if (empty($variationContext->theme)) {
            throw new \InvalidArgumentException('Current theme name is required into context under "theme" key.');
        }
        $variationNamespace = $variationContext->theme;
        unset($variationContext->theme);

        // conditions resolution
        $variationConfig = array();
        foreach ($this->variationConfigs->get($variationNamespace) as $namespace => $elements) {
            $variationConfig[$namespace] = array();
            foreach ($elements as $element => $config) {
                $variationConfig[$namespace][$element] = array_diff_key(
                    $config, array('variations' => true)
                );
                if (empty($config['variations'])) {
                    continue;
                }
                $elementConfig = &$variationConfig[$namespace][$element];
                foreach ($config['variations'] as $elementVariationConfig) {
                    if ($this->expressionParser->evaluate(
                        $elementVariationConfig['_if'],
                        $variationContext->normalize()
                    )) {
                        $elementConfig = array_replace_recursive(
                            $elementConfig,
                            $elementVariationConfig['_then']
                        );
                        if (!empty($elementVariationConfig['_last'])) {
                            break;
                        }
                    }
                    // elseif (!empty($elementVariationConfig['_else'])) {
                    //     if (!empty($elementVariationConfig['_else']['disabled'])) {
                    //         unset($variationConfig[$namespace][$element]);
                    //         break;
                    //     }
                    //     $elementConfig = array_replace_recursive(
                    //         $elementConfig,
                    //         $elementVariationConfig['_else']
                    //     );
                    //     if (!empty($elementVariationConfig['_last'])) {
                    //         break;
                    //     }
                    // }
                }
            }
        }

        return new Variation($variationConfig, $this->propertyAccessor);
    }
}
