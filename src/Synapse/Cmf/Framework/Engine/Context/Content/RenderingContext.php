<?php

namespace Synapse\Cmf\Framework\Engine\Context\Content;

use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;
use Synapse\Cmf\Framework\Theme\Variation\Entity\Variation;

/**
 * Synapse rendering context, used into all decorations from the framework
 * hold every required contextual objects.
 */
class RenderingContext
{
    /**
     * @var Content
     */
    protected $content;

    /**
     * @var ThemeInterface
     */
    protected $theme;

    /**
     * @var TemplateInterface
     */
    protected $template;

    /**
     * @var Variation
     */
    protected $variation;

    /**
     * Construct.
     *
     * @param ThemeInterface    $theme
     * @param TemplateInterface $template
     * @param Variation         $variation
     */
    public function __construct(
        Content $content,
        ThemeInterface $theme,
        TemplateInterface $template,
        Variation $variation
    ) {
        $this->content = $content;
        $this->theme = $theme;
        $this->template = $template;
        $this->variation = $variation;
    }

    /**
     * Returns context template content.
     *
     * @return Content
     */
    public function getContent()
    {
        return $this->content->unwrap();
    }

    /**
     * Returns context template.
     *
     * @return TemplateInterface
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Returns context theme.
     *
     * @return ThemeInterface
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Returns context template path.
     *
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->variation->getConfiguration(
            'templates',
            $this->template->getTemplateType()->getName(),
            'path'
        );
    }

    /**
     * Returns context zone virtual config.
     *
     * @param string $zoneName
     *
     * @return bool
     */
    public function isZoneVirtual($zoneName)
    {
        return $this->variation->getConfiguration('zones', $zoneName, 'virtual', false);
    }

    /**
     * Returns context zone aggregation strategy name config.
     *
     * @param string $zoneName
     * @param mixed  $default  optionnal default value
     *
     * @return string
     */
    public function getZoneAggregation($zoneName, $default = null)
    {
        return $this->variation->getConfiguration('zones', $zoneName, 'aggregation', $default);
    }
}
