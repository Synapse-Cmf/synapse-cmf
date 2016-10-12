<?php

namespace Synapse\Cmf\Framework\Theme\Template\Domain\Command;

use Synapse\Cmf\Framework\Theme\Content\Entity\Content;

/**
 * Specific create action, to use for content local template creation.
 */
class CreateLocalCommand extends CreateCommand
{
    /**
     * @var Content
     */
    protected $content;

    /**
     * @see CreateAction::createTemplate()
     */
    protected function createTemplate($templateClass)
    {
        return (new $templateClass())
            ->setLocal()
            ->setTemplateType($this->templateType)
            ->setContent($this->content)
        ;
    }

    /**
     * Define action content.
     *
     * @param Content $content
     *
     * @return self
     */
    public function setContent(Content $content)
    {
        $this->content = $content;

        return $this;
    }
}
