<?php

namespace Synapse\Cmf\Framework\Media\Media\Tests\Entity;

use Synapse\Cmf\Framework\Media\Media\Entity\Media;
use Synapse\Cmf\Framework\Media\Media\Entity\MediaCollection;

/**
 * Unit test class for MediaCollection.
 */
class MediaCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $mediaCollection = new MediaCollection();
        $mediaCollection->denormalize(array(
            'media_1' => array('id' => 42),
            'media_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            Media::class,
            $mediaCollection->get('media_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            Media::class,
            $mediaCollection->get('media_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'media_1' => 42,
                'media_2' => 66,
            ),
            $mediaCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
