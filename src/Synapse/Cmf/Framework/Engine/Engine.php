<?php

namespace Synapse\Cmf\Framework\Engine;

use Synapse\Cmf\Framework\Engine\Decorator\Component\HtmlDecorator as ComponentDecorator;
use Synapse\Cmf\Framework\Engine\Decorator\Content\HtmlDecorator as ContentDecorator;
use Synapse\Cmf\Framework\Engine\Decorator\Content\ImmutableDecorator;
use Synapse\Cmf\Framework\Engine\Resolver\ThemeResolver;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;

/**
 * Synapse engine main class, entry point of all other decorators.
 */
class Engine
{
    /**
     * @var ThemeResolver
     */
    protected $themeResolver;

    /**
     * @var ContentDecorator
     */
    protected $contentDecorator;

    /**
     * @var ComponentDecorator
     */
    protected $componentDecorator;

    /**
     * @var string
     */
    protected $currentThemeName;

    /**
     * Construct.
     *
     * @param ThemeResolver      $themeResolver
     * @param ContentDecorator   $contentDecorator
     * @param ComponentDecorator $componentDecorator
     */
    public function __construct(
        ThemeResolver $themeResolver,
        ContentDecorator $contentDecorator,
        ComponentDecorator $componentDecorator
    ) {
        $this->themeResolver = $themeResolver;
        $this->contentDecorator = $contentDecorator;
        $this->componentDecorator = $componentDecorator;
    }

    /**
     * Enable given theme name.
     *
     * @param string $themeName
     *
     * @return self
     */
    public function enableTheme($themeName)
    {
        $this->currentThemeName = $themeName;

        return $this;
    }

    /**
     * Create and return a DecoratorInterface for given content.
     *
     * @param ContentInterface|ComponentInterface $decorable
     * @param string                              $templateTypeName requested template type name to decorate decorable on
     *
     * @return Synapse\Cmf\Framework\Engine\Decorator\DecoratorInterface
     */
    public function createDecorator($decorable, $templateTypeName = null)
    {
        // Resolve theme
        $theme = $this->themeResolver->resolve($this->currentThemeName);

        // Main content rendering
        if ($decorable instanceof ContentInterface) {
            return new ImmutableDecorator(
                $decorable,
                $this->contentDecorator,
                $theme,
                $templateTypeName
            );
        }

        // Component rendering
        if ($decorable instanceof ComponentInterface) {
            return $this->componentDecorator;
        }

        throw new \InvalidArgumentException(sprintf(
            'Given decorable "%s" is not supported by Synapse. Check your configuration.',
            is_object($decorable) ? get_class($decorable) : gettype($decorable)
        ));
    }
}
