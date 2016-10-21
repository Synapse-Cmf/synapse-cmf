<?php

namespace Synapse\Cmf\Framework\Theme\Content\Tests\Entity;

use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;

/**
 * Unit test class for Content internal entity class.
 */
class ContentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests class construction.
     */
    public function testConstruct()
    {
        $contentType = $this->prophesize(ContentTypeInterface::class);

        $wrappedContent = $this->prophesize(ContentInterface::class);
        $wrappedContent->getContentId()->willReturn(42)->shouldBeCalled();

        $content = new Content(
            $wrappedContent = $wrappedContent->reveal(),
            $contentType = $contentType->reveal()
        );

        $this->assertEquals($contentType, $content->getType());
        $this->assertEquals($wrappedContent, $content->unwrap());
        $this->assertEquals(42, $content->getContentId());
    }
}
