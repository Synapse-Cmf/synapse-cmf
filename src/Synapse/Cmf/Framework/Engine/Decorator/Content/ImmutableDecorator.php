<?php

namespace Synapse\Cmf\Framework\Engine\Decorator\Content;

use Synapse\Cmf\Framework\Engine\Decorator\DecoratorInterface;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;

/**
 * Immutable wrapper for Synapse decorators.
 */
final class ImmutableDecorator implements DecoratorInterface
{
    /**
     * @var HtmlDecorator
     */
    protected $wrappedDecorator;

    /**
     * Construct.
     *
     * @param ContentInterface $decorable
     * @param HtmlDecorator    $wrappedDecorator
     * @param ThemeInterface   $theme
     * @param string           $templateTypeName
     */
    public function __construct(
        ContentInterface $decorable,
        HtmlDecorator $wrappedDecorator,
        ThemeInterface $theme,
        $templateTypeName = null
    ) {
        $this->wrappedDecorator = $wrappedDecorator->prepare(
            $decorable, $theme, $templateTypeName
        );
    }

    /**
     * @see DecoratorInterface::render()
     */
    public function render(array $templateParameters = array())
    {
        return $this->wrappedDecorator->render($templateParameters);
    }

    /**
     * @see DecoratorInterface::decorate()
     */
    public function decorate(array $templateParameters = array())
    {
        return $this->wrappedDecorator->decorate($templateParameters);
    }
}
