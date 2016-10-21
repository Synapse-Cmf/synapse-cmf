<?php

namespace Synapse\Cmf\Framework\Theme\Template\Domain\Command;

use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;

/**
 * Global template creation command representation.
 */
class CreateGlobalCommand extends CreateCommand
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
}
