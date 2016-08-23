<?php

namespace Synapse\Cmf\Framework\Theme\Template\Action\Dal;

use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;

/**
 * Specific create action, to use for content type global template creation.
 */
class CreateGlobalAction extends CreateAction
{
    /**
     * @var ContentTypeInterface
     */
    protected $contentType;

    /**
     * @see CreateAction::createTemplate()
     */
    protected function createTemplate($templateClass)
    {
        return (new $templateClass())
            ->setGlobal()
            ->setTemplateType($this->templateType)
            ->setContentType($this->contentType)
        ;
    }

    /**
     * Define action content type.
     *
     * @param ContentTypeInterface $contentType
     *
     * @return self
     */
    public function setContentType(ContentTypeInterface $contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Returns action content type.
     *
     * @return ContentTypeInterface
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Returns action template type.
     *
     * @return TemplateTypeInterface
     */
    public function getTemplateType()
    {
        return $this->templateType;
    }
}
