<?php

namespace Synapse\Cmf\Framework\Theme\Template\Loader;

use Majora\Framework\Loader\LoaderInterface as MajoraLoaderInterface;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateType;

/**
 * Interface for Template loading use cases.
 */
interface LoaderInterface extends MajoraLoaderInterface
{
    /**
     * Retrieve a template from a content type and a template type.
     *
     * @param TemplateType $theme
     * @param Content      $content
     *
     * @return TemplateInterface|null
     */
    public function retrieveDisplayable(TemplateType $templateType, Content $content);
}
