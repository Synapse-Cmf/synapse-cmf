<?php

namespace Synapse\Cmf\Framework\Theme\Content\Tests\Resolver;

use Synapse\Cmf\Framework\Engine\Exception\InvalidContentException;
use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentType;
use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentTypeCollection;
use Synapse\Cmf\Framework\Theme\ContentType\Loader\LoaderInterface;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;
use Synapse\Cmf\Framework\Theme\Content\Provider\ContentProviderInterface;
use Synapse\Cmf\Framework\Theme\Content\Resolver\ContentResolver;

/**
 * Unit test class for ContentResolver service.
 */
class ContentResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests resolve() method.
     */
    public function testResolve()
    {
        $contentTypeLoader = $this->prophesize(LoaderInterface::class);
        $contentTypeLoader->retrieveAll()
            ->willReturn(new ContentTypeCollection(array(
                $contentType = (new ContentType())
                    ->setId('synapse.content.type')
                    ->setContentClass(LocalContent::class),
                (new ContentType())
                    ->setId('synapse.content.type2')
                    ->setContentClass(LocalContent::class),
            )))
            ->shouldBeCalled()
        ;

        $contentResolver = new ContentResolver($contentTypeLoader->reveal());
        $localContent = new LocalContent();

        $this->assertEquals(
            new Content($localContent, $contentType),
            $content = $contentResolver->resolve($localContent)
        );
    }

    /**
     * Tests resolve() method with an unsupported content.
     */
    public function testResolveBadContent()
    {
        $contentTypeLoader = $this->prophesize(LoaderInterface::class);
        $contentTypeLoader->retrieveAll()
            ->willReturn(new ContentTypeCollection(array()))
            ->shouldBeCalled()
        ;

        $this->setExpectedException(InvalidContentException::class);

        $contentResolver = new ContentResolver($contentTypeLoader->reveal());
        $contentResolver->resolve(new LocalContent());
    }

    /**
     * Tests resolveContentId() method.
     */
    public function testResolveContentId()
    {
        $contentProvider = $this->prophesize(ContentProviderInterface::class);
        $contentProvider->retrieveContent(42)
            ->willReturn($localContent = new LocalContent())
            ->shouldBeCalled()
        ;

        $contentTypeLoader = $this->prophesize(LoaderInterface::class);
        $contentTypeLoader->retrieve('content_type_id')
            ->willReturn($contentType = (new ContentType())
                ->setId('content_type_id')
                ->setContentClass(LocalContent::class)
                ->setContentLoader($contentProvider->reveal())
            )
            ->shouldBeCalled()
        ;

        $contentResolver = new ContentResolver($contentTypeLoader->reveal());
        $this->assertEquals(
            new Content($localContent, $contentType),
            $content = $contentResolver->resolveContentId('content_type_id', 42)
        );
    }

    /**
     * Test resolveContentId() method with a bad content type.
     */
    public function testResolveContentIdBadContentType()
    {
        $contentTypeLoader = $this->prophesize(LoaderInterface::class);
        $contentTypeLoader->retrieve('content_type_id')->shouldBeCalled();

        $this->setExpectedException(InvalidContentException::class);

        $contentResolver = new ContentResolver($contentTypeLoader->reveal());
        $contentResolver->resolveContentId('content_type_id', 42);
    }

    /**
     * Test resolveContentId() method with a bad content type.
     */
    public function testResolveContentIdContentNotFound()
    {
        $contentProvider = $this->prophesize(ContentProviderInterface::class);
        $contentProvider->retrieveContent(42)
            ->shouldBeCalled()
        ;

        $contentTypeLoader = $this->prophesize(LoaderInterface::class);
        $contentTypeLoader->retrieve('content_type_id')
            ->willReturn($contentType = (new ContentType())
                ->setId('content_type_id')
                ->setContentClass(LocalContent::class)
                ->setContentLoader($contentProvider->reveal())
            )
            ->shouldBeCalled()
        ;

        $this->setExpectedException(InvalidContentException::class);

        $contentResolver = new ContentResolver($contentTypeLoader->reveal());
        $contentResolver->resolveContentId('content_type_id', 42);
    }
}

class LocalContent implements ContentInterface
{
    public function getContentId()
    {
        return 42;
    }
}
