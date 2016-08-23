<?php

namespace Synapse\Cmf\Framework\Engine\Decorator\Content;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface as TemplateEngine;
use Synapse\Cmf\Framework\Engine\Context\Content\RenderingContextBuilder;
use Synapse\Cmf\Framework\Engine\Context\RenderingContextStack;
use Synapse\Cmf\Framework\Engine\Decorator\DecoratorInterface;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;

/**
 * Content type decorator implementation using Html rendering.
 */
class HtmlDecorator implements DecoratorInterface
{
    /**
     * @var TemplateEngine
     */
    protected $templateEngine;

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
     * @param RenderingContextStack   $contextStack
     * @param RenderingContextBuilder $contextBuilder
     * @param TemplateEngine          $templateEngine
     */
    public function __construct(
        RenderingContextStack $contextStack,
        RenderingContextBuilder $contextBuilder,
        TemplateEngine $templateEngine
    ) {
        $this->templateEngine = $templateEngine;
        $this->contextStack = $contextStack;
        $this->contextBuilder = $contextBuilder;
    }

    /**
     * Prepare a rendering context from given content and theme.
     *
     * @param ContentInterface $content
     * @param ThemeInterface   $theme
     * @param string           $templateTypeName
     *
     * @return self
     */
    public function prepare(ContentInterface $content, ThemeInterface $theme, $templateTypeName = null)
    {
        $this->contextStack->push(
            $this->contextBuilder
                ->setContent($content)
                ->setTheme($theme)
                ->setTemplateTypeName($templateTypeName)
            ->createContext()
        );

        return $this;
    }

    /**
     * @see DecoratorInterface::render()
     */
    public function render(array $templateParameters = array())
    {
        // render template from current context
        $decoratedContent = $this->templateEngine->render(
            $this->contextStack->getCurrent()->getTemplatePath(),
            $templateParameters
        );

        // unstack context
        $this->contextStack->pop();

        return $decoratedContent;
    }

    /**
     * @see DecoratorInterface::decorate()
     */
    public function decorate(array $templateParameters = array())
    {
        return new Response($this->render($templateParameters));
    }
}
