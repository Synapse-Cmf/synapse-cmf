<?php

namespace Synapse\Cmf\Framework\Media\FormattedImage\Tests\Entity;

use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImage;
use Synapse\Cmf\Framework\Media\FormattedImage\Entity\FormattedImageCollection;

/**
 * Unit test class for FormattedImageCollection.
 */
class FormattedImageCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $formattedImageCollection = new FormattedImageCollection();
        $formattedImageCollection->denormalize(array(
            'formatted_image_1' => array('id' => 42),
            'formatted_image_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            FormattedImage::class,
            $formattedImageCollection->get('formatted_image_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            FormattedImage::class,
            $formattedImageCollection->get('formatted_image_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'formatted_image_1' => 42,
                'formatted_image_2' => 66,
            ),
            $formattedImageCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
