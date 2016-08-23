<?php

namespace Synapse\Cmf\Framework\Theme\ZoneType\Tests\Entity;

use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneType;
use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneTypeCollection;

/**
 * Unit test class for ZoneTypeCollection.
 */
class ZoneTypeCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests serialization process.
     */
    public function testSerialization()
    {
        $zoneTypeCollection = new ZoneTypeCollection();
        $zoneTypeCollection->denormalize(array(
            'zone_type_1' => array('id' => 42),
            'zone_type_2' => array('id' => 66),
        ));

        $this->assertInstanceOf(
            ZoneType::class,
            $zoneTypeCollection->get('zone_type_1'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertInstanceOf(
            ZoneType::class,
            $zoneTypeCollection->get('zone_type_2'),
            'Deserialization process hydrate a related entity class object and index it under given key.'
        );
        $this->assertEquals(
            array(
                'zone_type_1' => 42,
                'zone_type_2' => 66,
            ),
            $zoneTypeCollection->normalize('id'),
            'Serialization scopes are transmitted to related entity serialization process.'
        );
    }
}
