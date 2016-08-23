<?php

namespace Synapse\Cmf\Bundle\Theme\Matcher;

use Majora\Framework\Model\EntityCollection;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Engine\Engine;
use Synapse\Cmf\Framework\Engine\Exception\InvalidThemeException;

/**
 * Aggregator class for all matching strategies.
 */
class ThemeMatcher
{
    /**
     * @var Engine
     */
    protected $synapseEngine;

    /**
     * @var ExpressionLanguage
     */
    protected $expressionParser;

    /**
     * @var EntityCollection
     */
    protected $matchers;

    /**
     * @var array
     */
    private $resolutionStrategies;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * Construct.
     *
     * @param Engine             $synapseEngine
     * @param ExpressionLanguage $expressionParser
     */
    public function __construct(Engine $synapseEngine, ExpressionLanguage $expressionParser)
    {
        $this->synapseEngine = $synapseEngine;
        $this->expressionParser = $expressionParser;

        $this->matchers = new EntityCollection();
        $this->resolutionStrategies = array(
            // return configured name
            'name' => function ($config, ThemeMatchingContext $context) {
                return is_string($config) && empty($config) ? null : $config;
            },
            // return theme matched from a host pattern
            'host' => function ($config, ThemeMatchingContext $context) {
                if (is_string($config)) {
                    if (preg_match(sprintf('/%s/', $config), $context->host, $matches)) {
                        return empty($matches[1]) ? null : $matches[1];
                    }

                    return;
                }
                if (!is_array($config)) {
                    throw new \InvalidArgumentException(
                        'Host theme matching strategy only works with a "theme_name" => "host" pattern map or a general regex with a capture on theme name.'
                    );
                }
                foreach ($config as $themeName => $patterns) {
                    foreach ((array) $patterns as $pattern) {
                        if (preg_match(sprintf('/%s/', $pattern), $context->host)) {
                            return $themeName;
                        }
                    }
                }
            },
            // expression language condition map
            'expression' => function ($config, ThemeMatchingContext $context) {
                if (!is_array($config)) {
                    throw new \InvalidArgumentException(
                        'Conditional theme matching strategy only works with a "theme_name" => "conditionnal expression" map.'
                    );
                }
                foreach ($config as $themeName => $condition) {
                    if ($this->expressionParser->evaluate($condition, $context->normalize())) {
                        return $themeName;
                    }
                }
            },
        );

        $this->optionsResolver = new OptionsResolver();
        $this->optionsResolver->setDefined(array_keys($this->resolutionStrategies));
    }

    /**
     * Register a new theme matcher.
     *
     * @param string                $name
     * @param ThemeMatcherInterface $matcher
     */
    public function registerThemeMatcher($name, ThemeMatcherInterface $matcher)
    {
        $this->matchers->set($name, $matcher);
    }

    /**
     * Try to find a template name from given options and context.
     *
     * @param string|array         $options
     * @param ThemeMatchingContext $context
     *
     * @throws InvalidThemeException
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\OptionsResolver\Exception\ExceptionInterface
     */
    public function match($options, ThemeMatchingContext $context)
    {
        // only name given
        if (is_string($options)) {
            $options = array('name' => $options);
        }

        // validate options
        $options = $this->optionsResolver->resolve($options);
        if (empty($options)) {
            throw new \InvalidArgumentException('You must at least define one theme loading option.');
        }

        // run strategies from options
        foreach ($options as $key => $option) {
            try {
                if ($local = $this->resolutionStrategies[$key]($option, $context)) {
                    $theme = $local;
                }
            } catch (InvalidThemeException $e) {
                continue;
            }
        }
        if (empty($theme)) {
            throw new InvalidThemeException(sprintf(
                'Unavailable to match a theme throught "%s" strategies and given context. Check your configuration.',
                implode('", "', array_keys($options))
            ));
        }

        $this->synapseEngine->enableTheme($theme);

        return $theme;
    }
}
