<?php

namespace Synapse\Cmf\Framework\Media\Format\Tests\Entity;

use Synapse\Cmf\Framework\Media\Format\Entity\Format;
use Synapse\Cmf\Framework\Media\Format\Entity\FormatCollection;

/**
 * Unit test class for FormatCollection.
 */
class FormatCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $formatCollection = new FormatCollection();
        $formatCollection->denormalize(array(
            'format_1' => array('id' => 42),
            'format_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            Format::class,
            $formatCollection->get('format_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            Format::class,
            $formatCollection->get('format_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'format_1' => 42,
                'format_2' => 66,
            ),
            $formatCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
