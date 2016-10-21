<?php

namespace Synapse\Cmf\Framework\Theme\Content\Resolver;

use Synapse\Cmf\Framework\Engine\Exception\InvalidContentException;
use Synapse\Cmf\Framework\Theme\ContentType\Loader\LoaderInterface as ContentTypeLoader;
use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;

/**
 * Class which resolves a given custom content into a proper Synapse content.
 */
class ContentResolver
{
    /**
     * @var ContentTypeLoader
     */
    protected $contentTypeLoader;

    /**
     * Construct.
     *
     * @param ContentTypeLoader $contentTypeLoader
     */
    public function __construct(ContentTypeLoader $contentTypeLoader)
    {
        $this->contentTypeLoader = $contentTypeLoader;
    }

    /**
     * Resolve given Content into Synapse internal content class.
     *
     * @param ContentInterface $content
     *
     * @return Content
     */
    public function resolve(ContentInterface $content)
    {
        $contentType = $this->contentTypeLoader->retrieveAll()
            ->filter(function (ContentTypeInterface $contentType) use ($content) {
                return is_a($content, $contentType->getContentClass());
            })
            ->first()
        ;
        if (!$contentType) {
            throw new InvalidContentException(sprintf(
                'No content type registered for "%s" content, check you configuration.',
                is_string($content) ? $content : get_class($content)
            ));
        }

        return $this->wrap($contentType, $content);
    }

    /**
     * Resolve given content type id / content id couple into Synapse internal content class.
     *
     * @param string $contentTypeId
     * @param string $contentId
     *
     * @return Content
     */
    public function resolveContentId($contentTypeId, $contentId)
    {
        // content type ?
        if (!$contentType = $this->contentTypeLoader->retrieve($contentTypeId)) {
            throw new InvalidContentException(sprintf(
                'No content type registered under "%s" id, check you configuration.',
                $contentTypeId
            ));
        }

        // content object
        if (!$content = $contentType->retrieveContent($contentId)) {
            throw new InvalidContentException(sprintf(
                'Unable to get a "%s" content under "%s" id.',
                $contentType->getName(),
                $contentId
            ));
        }

        return $this->wrap($contentType, $content);
    }

    /**
     * Wrap given content type and content object into Synapse Content internal wrapper.
     *
     * @param ContentTypeInterface $contentType
     * @param ContentInterface     $content
     *
     * @return Content
     */
    protected function wrap(ContentTypeInterface $contentType, ContentInterface $content)
    {
        return new Content($content, $contentType);
    }
}
