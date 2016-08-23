<?php

namespace Synapse\Cmf\Framework\Theme\Zone\Tests\Entity;

use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Unit test class for ZoneCollection.
 */
class ZoneCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $zoneCollection = new ZoneCollection();
        $zoneCollection->denormalize(array(
            'zone_1' => array('id' => 42),
            'zone_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            Zone::class,
            $zoneCollection->get('zone_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            Zone::class,
            $zoneCollection->get('zone_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'zone_1' => 42,
                'zone_2' => 66,
            ),
            $zoneCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
