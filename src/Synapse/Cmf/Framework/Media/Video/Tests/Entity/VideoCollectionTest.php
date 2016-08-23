<?php

namespace Synapse\Cmf\Framework\Media\Video\Tests\Entity;

use Synapse\Cmf\Framework\Media\Video\Entity\Video;
use Synapse\Cmf\Framework\Media\Video\Entity\VideoCollection;

/**
 * Unit test class for VideoCollection.
 */
class VideoCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $videoCollection = new VideoCollection();
        $videoCollection->denormalize(array(
            'video_1' => array('id' => 42),
            'video_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            Video::class,
            $videoCollection->get('video_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            Video::class,
            $videoCollection->get('video_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'video_1' => 42,
                'video_2' => 66,
            ),
            $videoCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
