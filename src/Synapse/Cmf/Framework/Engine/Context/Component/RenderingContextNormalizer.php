<?php

namespace Synapse\Cmf\Framework\Engine\Context\Component;

use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Content\Resolver\ContentResolver;
use Synapse\Cmf\Framework\Theme\Template\Loader\LoaderInterface as TemplateLoader;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Theme\Loader\LoaderInterface as ThemeLoader;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;
use Synapse\Cmf\Framework\Theme\Zone\Loader\LoaderInterface as ZoneLoader;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Normalizer class used to normalize / denormalize a component context.
 */
class RenderingContextNormalizer
{
    /**
     * @var ContentResolver
     */
    protected $contentResolver;

    /**
     * @var ThemeLoader
     */
    protected $themeLoader;

    /**
     * @var TemplateLoader
     */
    protected $templateLoader;

    /**
     * @var ZoneLoader
     */
    protected $zoneLoader;

    /**
     * Construct.
     *
     * @param ContentResolver $contentResolver
     * @param ThemeLoader     $themeLoader
     * @param TemplateLoader  $templateLoader
     * @param ZoneLoader      $zoneLoader
     */
    public function __construct(
        ContentResolver $contentResolver,
        ThemeLoader $themeLoader,
        TemplateLoader $templateLoader,
        ZoneLoader $zoneLoader
    ) {
        $this->contentResolver = $contentResolver;
        $this->themeLoader = $themeLoader;
        $this->templateLoader = $templateLoader;
        $this->zoneLoader = $zoneLoader;
    }

    /**
     * Normalize given context data into an array.
     *
     * @param Content            $content
     * @param ThemeInterface     $theme
     * @param TemplateInterface  $template
     * @param ZoneInterface      $zone
     * @param ComponentInterface $component
     *
     * @return array
     */
    public function normalize(
        Content $content,
        ThemeInterface $theme,
        TemplateInterface $template,
        ZoneInterface $zone,
        ComponentInterface $component
    ) {
        return array('_s_context' => array(
            'content' => array($content->getType()->getName(), $content->getContentId()),
            'theme' => $theme->getName(),
            'template' => $template->getId(),
            'zone' => $zone->getId(),
            'component' => $component->getId(),
        ));
    }

    public function denormalize(array $contextData)
    {
        $data = $contextData['_s_context'];

        if (!$template = $this->templateLoader->retrieve($data['template'])) {
            throw new \InvalidArgumentException(sprintf(
                'Any template found under id #%s.', $data['template']
            ));
        }
        if ((!$zone = $template->getZones()->search(array('id' => $data['zone']))->first())
            && !$zone = $this->zoneLoader->retrieve($data['zone'])
        ) {
            throw new \InvalidArgumentException(sprintf(
                'Any zone found under id #%s with template #%s or in global template.',
                $data['zone'],
                $data['template']
            ));
        }
        if (!$component = $zone->getComponents()->search(array('id' => $data['component']))->first()) {
            throw new \InvalidArgumentException(sprintf(
                'Any component found under id #%s in zone #%s.',
                $data['component'],
                $data['zone']
            ));
        }

        return array(
            $this->contentResolver->resolve(...$data['content']),
            $this->themeLoader->retrieveByName($data['theme']),
            $template,
            $zone,
            $component,
        );
    }
}
