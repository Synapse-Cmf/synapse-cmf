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
     * Resolve given ContentInterface into a Synapse content object.
     *
     * @param ContentInterface|string $content Content object or content type name
     * @param scalar                  $id      Content id, required if name given
     *
     * @return Content
     *
     * @throws BadMethodCallException  If no id given with content type name as first arg
     * @throws InvalidContentException If given content isnt supported
     */
    public function resolve($content, $id = null)
    {
        if (is_string($content) && !$id) {
            throw new \BadMethodCallException(
                'You have to provide both content type name and content id without given ContentInterface object.'
            );
        }
        if (is_object($content) && !$content instanceof ContentInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Given %s object is not a ContentInterface.',
                get_class($content)
            ));
        }

        // iterate over all content types for inheritence checking
        $contentType = $content instanceof ContentInterface
            ? $this->contentTypeLoader->retrieveAll()
                ->filter(function (ContentTypeInterface $contentType) use ($content) {
                    return is_a($content, $contentType->getContentClass());
                })
                ->first()
            : $this->contentTypeLoader->retrieve($content)
        ;
        if (!$contentType) {
            throw new InvalidContentException(sprintf(
                'Unsupported content : "%s", check you configuration.',
                is_string($content) ? $content : get_class($content)
            ));
        }

        return new Content(
            $content instanceof ContentInterface
                ? $content
                : $contentType->retrieveContent($id),
            $contentType
        );
    }
}
