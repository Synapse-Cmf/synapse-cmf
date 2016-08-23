<?php

namespace Synapse\Cmf\Framework\Theme\Content\Entity;

use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;

/**
 * ContentInterface wrapping value object used for internal purposes.
 */
final class Content
{
    /**
     * @var ContentInterface
     */
    private $wrappedContent;

    /**
     * @var ContentTypeInterface
     */
    private $contentType;

    /**
     * Construct.
     *
     * @param ContentInterface     $wrappedContent
     * @param ContentTypeInterface $contentType
     */
    public function __construct(
        ContentInterface $wrappedContent,
        ContentTypeInterface $contentType
    ) {
        $this->wrappedContent = $wrappedContent;
        $this->contentType = $contentType;
    }

    /**
     * Returns Content content type.
     *
     * @return ContentTypeInterface
     */
    public function getType()
    {
        return $this->contentType;
    }

    /**
     * Returns Content wrapped content id.
     *
     * @return scalar
     */
    public function getContentId()
    {
        return $this->wrappedContent->getContentId();
    }

    /**
     * Return Content wrapped content.
     *
     * @return ContentInterface
     */
    public function unwrap()
    {
        return $this->wrappedContent;
    }
}
