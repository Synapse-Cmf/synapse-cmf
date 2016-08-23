<?php

namespace Synapse\Cmf\Framework\Theme\ContentType\Tests\Entity;

use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentType;
use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentTypeCollection;

/**
 * Unit test class for ContentTypeCollection.
 */
class ContentTypeCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $contentTypeCollection = new ContentTypeCollection();
        $contentTypeCollection->denormalize(array(
            'content_type_1' => array('id' => 42),
            'content_type_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            ContentType::class,
            $contentTypeCollection->get('content_type_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            ContentType::class,
            $contentTypeCollection->get('content_type_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'content_type_1' => 42,
                'content_type_2' => 66,
            ),
            $contentTypeCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
