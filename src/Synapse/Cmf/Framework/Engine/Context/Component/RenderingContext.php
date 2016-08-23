<?php

namespace Synapse\Cmf\Framework\Engine\Context\Component;

use Synapse\Cmf\Framework\Engine\Context\Content\RenderingContext as ContentRenderingContext;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Variation\Entity\Variation;

/**
 * Specific context for component rendering process.
 */
class RenderingContext extends ContentRenderingContext
{
    /**
     * @var ComponentInterface
     */
    protected $component;

    /**
     * @var array
     */
    protected $normalizedData;

    /**
     * Construct.
     *
     * @param ComponentInterface $component
     * @param Content            $content
     * @param Variation          $variation
     * @param array              $normalizedData
     */
    public function __construct(ComponentInterface $component, Content $content, Variation $variation, array $normalizedData)
    {
        $this->component = $component;
        $this->content = $content;
        $this->variation = $variation;
        $this->normalizedData = $normalizedData;
    }

    /**
     * Return context component.
     *
     * @return ComponentInterface
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Returns context component controller.
     *
     * @return string
     */
    public function getController()
    {
        if ($controllerData = $this->component->getData('_controller')) {
            return $controllerData;
        }

        return $this->variation->getConfiguration(
            'components',
            $this->component->getComponentType()->getName(),
            'controller',
            $this->component->getComponentType()->getController()
        );
    }

    /**
     * Returns context component template path.
     *
     * @return string
     */
    public function getTemplatePath()
    {
        if ($templateData = $this->component->getData('_template')) {
            return $templateData;
        }

        return $this->variation->getConfiguration(
            'components',
            $this->component->getComponentType()->getName(),
            'path',
            $this->component->getComponentType()->getTemplatePath()
        );
    }

    /**
     * Returns context component config.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->variation->getConfiguration(
            'components',
            $this->component->getComponentType()->getName(),
            'config',
            array()
        );
    }

    /**
     * Normalize this context into an array.
     *
     * @return array
     */
    public function normalize()
    {
        return $this->normalizedData;
    }
}
