<?php

namespace Synapse\Cmf\Framework\Theme\Template\Domain;

use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Interface for Template domain use cases.
 */
interface DomainInterface
{
    /**
     * Create a local template linked to given content only, on given template type.
     *
     * @param ContentInterface             $content
     * @param string|TemplateTypeInterface $templateType template type object or template type name
     * @param ZoneCollection               $zones
     *
     * @return TemplateInterface
     */
    public function createLocal(ContentInterface $content, $templateType, ZoneCollection $zones = null);

    /**
     * Create a global template for given content type, on given template type.
     *
     * @param ContentInterface|Content|ContentType|string $content      content, internal content,
     *                                                                  content type object or content type name
     * @param string|TemplateTypeInterface                $templateType template type object or template type name
     * @param ZoneCollection                              $zones
     *
     * @return TemplateInterface
     */
    public function createGlobal($content, $templateType, ZoneCollection $zones = null);

    /**
     * Update given template with given parameters.
     *
     * @param TemplateInterface $template
     */
    public function edit(TemplateInterface $template);

    /**
     * Delete given template.
     *
     * @param TemplateInterface $template
     */
    public function delete(TemplateInterface $template);
}
