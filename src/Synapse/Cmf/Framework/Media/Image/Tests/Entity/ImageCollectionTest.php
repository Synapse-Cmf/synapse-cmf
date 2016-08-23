<?php

namespace Synapse\Cmf\Framework\Media\Image\Tests\Entity;

use Synapse\Cmf\Framework\Media\Image\Entity\Image;
use Synapse\Cmf\Framework\Media\Image\Entity\ImageCollection;

/**
 * Unit test class for ImageCollection.
 */
class ImageCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $imageCollection = new ImageCollection();
        $imageCollection->denormalize(array(
            'image_1' => array('id' => 42),
            'image_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            Image::class,
            $imageCollection->get('image_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            Image::class,
            $imageCollection->get('image_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'image_1' => 42,
                'image_2' => 66,
            ),
            $imageCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
